<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    //
    public function index()
    {
        return view('barang.index');
    }

    public function getDataBarang(Request $request)
    {
        if ($request->ajax()) {
            $data = DataBarang::All();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('stock', function ($row) {
                    return $row->stock->qty ?? '-';
                })
                ->make(true);
        }
    }
}
