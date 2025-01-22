<?php

namespace App\Http\Controllers;

use App\Models\DataSuplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SuplierController extends Controller
{
    //
    public function index()
    {
        return view('suplier.index');
    }

    public function getDataSuplier(Request $request)
    {
        if ($request->ajax()) {
            $data = DataSuplier::All();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
