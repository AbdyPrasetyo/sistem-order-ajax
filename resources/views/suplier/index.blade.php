@extends('welcome')
@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-dark fw-bold">Daftar Suplier</h1>

    <div class="card shadow-sm">
        <div class="card-body">
    <table id="dataSuplier" class="table  table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Suplier</th>
                <th>Nama Suplier</th>
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
        $('#dataSuplier').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('suplier.getDataSuplier') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kodespl', name: 'kodespl' },
                { data: 'namaspl', name: 'namaspl' },
            ]
        });
    });
</script>
@endsection
