@extends('welcome')
@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-dark fw-bold">Daftar Barang</h1>

    <div class="card shadow-sm">
        <div class="card-body">
    <table id="dataBarang" class="table  table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script>


<script>
    $(document).ready(function () {
        $('#dataBarang').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('barang.getDataBarang') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kodebrg', name: 'kodebrg' },
                { data: 'namabrg', name: 'namabrg' },
                { data: 'satuan', name: 'satuan' },
                { data: 'hargabeli', name: 'hargabeli' },
                { data: 'stock', name: 'stock' },
            ]
        });
    });
</script>
@endsection
