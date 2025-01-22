<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\DataStok;
use App\Models\DataBarang;
use App\Models\DataSuplier;
use Illuminate\Http\Request;
use App\Models\DataTransaksi;
use Illuminate\Support\Facades\DB;
use App\Models\DataDetailTransaksi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {

        $suplier = DataSuplier::All();
        $barang  = DataBarang::All();
        return view('transaksi.transaksi', compact('suplier', 'barang'));
    }

    public function getTransaksiData(Request $request)
    {
        if ($request->ajax()) {
            $data = DataTransaksi::with(['suplier', 'detailtransaksi.barang'])->get();

            return DataTables::of($data)
                ->addColumn('suplier', function ($row) {
                    return $row->suplier->kodespl ?? '-';
                })
                ->addColumn('details', function ($row) {
                    $details = '';
                    foreach ($row->detailtransaksi as $detail) {
                        $details .= "
                            <div>
                                <strong>Barang:</strong> {$detail->barang->namabrg} <br>
                                <strong>Qty:</strong> {$detail->qty} <br>
                                <strong>Harga:</strong> Rp" . number_format($detail->barang->hargabeli, 0, ',', '.') . " <br>
                                <strong>Diskon:</strong> Rp" . number_format($detail->diskonrp, 0, ',', '.') . " <br>
                                <strong>Total:</strong> Rp" . number_format($detail->totalrp, 0, ',', '.') . "
                            </div><hr>";
                    }
                    return $details;
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('transaksi.edit', $row->id);
                    $deleteUrl = route('transaksi.destroy', $row->id);
                    return '
                        <button class="btn btn-warning btn-sm  edit-btn" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['details','action'])
                ->make(true);
        }
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'suplier_id' => 'required|exists:tbl_suplier,id',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:tbl_barang,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'diskon' => 'nullable|array',
            'diskon.*' => 'nullable|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $tahun = Carbon::now()->year;
        $bulan = Carbon::now()->month;
        $lastTransaction = DataTransaksi::orderBy('id', 'desc')->first();
        $lastId = $lastTransaction ? (int) substr($lastTransaction->notransaksi, 5, 3) : 0;
        $nextId = $lastId + 1;

        $notransaksi = 'B' . $tahun . str_pad($bulan, 2, '0', STR_PAD_LEFT) . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $transaksi = DataTransaksi::create([
            'notransaksi' => $notransaksi,
            'id_suplier' => $validated['suplier_id'],
            'tglbeli' => Carbon::now(),
        ]);

        $totalrp = 0;

        try {

            $barang = DataBarang::whereIn('id', $validated['barang_id'])->get();
            $stok = DataStok::whereIn('id_barang', $validated['barang_id'])->get()->keyBy('id_barang');

            foreach ($validated['barang_id'] as $key => $barangId) {
                $barangData = $barang->firstWhere('id', $barangId);
                $qty = $validated['qty'][$key];
                $diskon = $validated['diskon'][$key] ?? 0;

                $total = $barangData->hargabeli * $qty;
                $diskonRp = $total * ($diskon / 100);
                $totalRp = $total - $diskonRp;


                DataDetailTransaksi::create([
                    'id_hbeli' => $transaksi->id,
                    'id_barang' => $barangId,
                    'qty' => $qty,
                    'diskon' => $diskon,
                    'diskonrp' => $diskonRp,
                    'totalrp' => $totalRp,
                ]);


                if (isset($stok[$barangId]) && $stok[$barangId]->qty >= $qty) {
                    $stok[$barangId]->qty -= $qty;
                    $stok[$barangId]->save();
                } else {
                    throw new Exception('Stok tidak mencukupi untuk barang ' . $barangData->namabrg);
                }

                $totalrp += $totalRp;
            }

            return response()->json([
                'message' => 'Transaksi berhasil disimpan.',
                'notransaksi' => $notransaksi,
                'totalrp' => $totalrp,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $transaksi = DataTransaksi::with('suplier', 'detailtransaksi')->find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'suplier_id' => 'required|exists:tbl_suplier,id',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:tbl_barang,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'diskon' => 'nullable|array',
            'diskon.*' => 'nullable|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();


        $transaksi = DataTransaksi::find($id);
        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan.',
            ], 404);
        }


        $transaksi->id_suplier = $validated['suplier_id'];
        $transaksi->tglbeli = Carbon::now();
        $transaksi->save();


        DataDetailTransaksi::where('id_hbeli', $id)->delete();


        $totalrp = 0;
        $barang = DataBarang::whereIn('id', $validated['barang_id'])->get();
        $stok = DataStok::whereIn('id_barang', $validated['barang_id'])->get()->keyBy('id_barang');

        try {
            foreach ($validated['barang_id'] as $key => $barangId) {
                $barangData = $barang->firstWhere('id', $barangId);
                $qty = $validated['qty'][$key];
                $diskon = $validated['diskon'][$key] ?? 0;

                $total = $barangData->hargabeli * $qty;
                $diskonRp = $total * ($diskon / 100);
                $totalRp = $total - $diskonRp;


                DataDetailTransaksi::create([
                    'id_hbeli' => $transaksi->id,
                    'id_barang' => $barangId,
                    'qty' => $qty,
                    'diskon' => $diskon,
                    'diskonrp' => $diskonRp,
                    'totalrp' => $totalRp,
                ]);


                if (isset($stok[$barangId]) && $stok[$barangId]->qty >= $qty) {
                    $stok[$barangId]->qty -= $qty;
                    $stok[$barangId]->save();
                } else {
                    throw new Exception('Stok tidak mencukupi untuk barang ' . $barangData->namabrg);
                }

                $totalrp += $totalRp;
            }

            return response()->json([
                'message' => 'Transaksi berhasil diperbarui.',
                'notransaksi' => $transaksi->notransaksi,
                'totalrp' => $totalrp,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        $transaksi = DataTransaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus'], 200);
    }
}
