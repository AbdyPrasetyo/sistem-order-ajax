@extends('welcome')
@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4 text-dark fw-bold">Daftar Pembelian</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
                Add Transaksi
            </button>
            <table class="table table-bordered table-striped" id="transaksi-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No Transaksi</th>
                        <th scope="col">Kode Suplier</th>
                        <th scope="col">Tanggal Beli</th>
                        <th scope="col">Detail Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('transaksi.script')
@include('transaksi.modalAdd')
@include('transaksi.modalEdit')
@endsection





