<?php

namespace App\Http\Controllers;

use App\Models\DataStok;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StockController extends Controller
{
    //
    public function index()
    {
        return view('stok.index');
    }

    public function getDataStock(Request $request)
    {
        if ($request->ajax()) {
            $data = DataStok::with('barang')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_barang', function ($row) {
                    return $row->barang->namabrg ?? '-';
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
