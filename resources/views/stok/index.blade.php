@extends('welcome')
@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-dark fw-bold">Daftar Stok</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <button id="exportButton" class="btn btn-success mb-3">Ekspor ke Excel</button>
            <button id="exportButtonPDF" class="btn btn-danger mb-3">Ekspor ke PDF</button>

    <table id="dataStok" class="table  table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>QTY</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>


<script>
    $(document).ready(function () {
        var table =  $('#dataStok').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('stok.getDataStock') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'qty', name: 'qty' },
            ],

        });

        $('#exportButton').click(function () {
        var tableData = table.rows().data().toArray();
        var ws = XLSX.utils.aoa_to_sheet([['No', 'Nama Barang', 'QTY']].concat(tableData.map(function(row) {
            return [row.DT_RowIndex, row.nama_barang, row.qty];
        })));


        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Stok');
        XLSX.writeFile(wb, 'data_stok.xlsx');
    });

    $('#exportButtonPDF').click(function () {
        var tableData = table.rows().data().toArray();
        const { jsPDF } = window.jspdf;
        var doc = new jsPDF();
        var body = tableData.map(function(row) {
            return [row.DT_RowIndex, row.nama_barang, row.qty];
        });

        doc.autoTable({
            head: [['No', 'Nama Barang', 'QTY']],
            body: body
        });
        doc.save('data_stok.pdf');
    });
    });
</script>
@endsection
