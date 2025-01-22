
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script>


<script>
    $(document).ready(function () {


        var table =  $('#transaksi-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transaksi.getData') }}",
            columns: [
                { data: 'notransaksi', name: 'notransaksi' },
                { data: 'suplier', name: 'suplier' },
                { data: 'tglbeli', name: 'tglbeli' },
                { data: 'details', name: 'details', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],

        });


        $('#addBarangBtn').on('click', function() {
        var newBarangGroup = `
            <div class="row barang-group mt-2">
                <div class="col-md-4">
                    <label for="barang">Barang</label>
                    <select name="barang_id[]" class="form-select" required>
                        <option value="">Pilih Barang</option>
                        @foreach ($barang as $brg)
                            <option value="{{ $brg->id }}">{{ $brg->kodebrg }} [{{ $brg->namabrg }}]</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="barang_error"></span>
                </div>

                <div class="col-md-4">
                    <label for="qty">Jumlah</label>
                    <input type="number" name="qty[]" min="1" class="form-control" required>
                    <span class="text-danger" id="qty_error"></span>
                </div>

                <div class="col-md-4">
                    <label for="diskon">Diskon (%)</label>
                    <input type="number" name="diskon[]" min="0" max="100" class="form-control">
                    <span class="text-danger" id="diskon_error"></span>
                </div>
            </div>
        `;

        $('#barang-container').append(newBarangGroup);
    });
        $(document).on('submit', '#addTransaksiForm', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route("transaksi.store") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.message == 'Transaksi berhasil disimpan.') {
                        $('#addModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#transaksi-table').DataTable().ajax.reload();
                        $('body').css('overflow', 'auto');
                        $('html').css('overflow', 'auto');
                         setTimeout(function() {
                            $('body').css('overflow', 'auto');
                         }, 100);
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;

                    if (errors.suplier_id) {
                        alert(errors.suplier_id[0]);
                    }
                    if (errors.barang_id) {
                        alert(errors.barang_id[0]);
                    }
                    if (errors.qty) {
                        alert(errors.qty[0]);
                    }
                    if (errors.diskon) {
                        alert(errors.diskon[0]);
                    }
                }
            });
            });


            $(document).on('click', '.edit-btn', function() {
    var id = $(this).data('id');
    $.ajax({
        url: '/transaksi/' + id + '/edit',
        method: 'GET',
        success: function(response) {

            $('#editTransaksiId').val(response.id);
            $('#editNotransaksi').val(response.notransaksi);
            $('#editSuplier').val(response.id_suplier);


            $('#edit-barang-container').html('');


            response.detailtransaksi.forEach(function(detail) {
                var barangRow = `
                    <div class="row barang-group mt-2">
                        <div class="col-md-4">
                            <label for="barang">Barang</label>
                            <select name="barang_id[]" class="form-select" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $brg)
                                    <option value="{{ $brg->id }}" ${detail.id_barang == {{ $brg->id }} ? 'selected' : ''}>
                                        {{ $brg->kodebrg }} [{{ $brg->namabrg }}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="qty">Jumlah</label>
                            <input type="number" name="qty[]" min="1" class="form-control" value="${detail.qty}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="diskon">Diskon (%)</label>
                            <input type="number" name="diskon[]" min="0" max="100" class="form-control" value="${detail.diskon}">
                        </div>
                    </div>
                `;
                $('#edit-barang-container').append(barangRow);
            });


            $('#editModal').modal('show');
        },
        error: function(xhr) {
            alert('Gagal mengambil data transaksi.');
        }
    });
});
$('#addEditBarangBtn').on('click', function() {
    var newBarangGroup = `
        <div class="row barang-group mt-2">
            <div class="col-md-4">
                <label for="barang">Barang</label>
                <select name="barang_id[]" class="form-select" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($barang as $brg)
                        <option value="{{ $brg->id }}">{{ $brg->kodebrg }} [{{ $brg->namabrg }}]</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="qty">Jumlah</label>
                <input type="number" name="qty[]" min="1" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="diskon">Diskon (%)</label>
                <input type="number" name="diskon[]" min="0" max="100" class="form-control">
            </div>
        </div>
    `;
    $('#edit-barang-container').append(newBarangGroup);
});


$(document).on('submit', '#editTransaksiForm', function(e) {
    e.preventDefault();

    var id = $('#editTransaksiId').val();
    var formData = $(this).serialize();

    $.ajax({
        url: '/transaksi/' + id,
        method: 'PUT',
        data: formData,
        success: function(response) {
            if (response.message == 'Transaksi berhasil diperbarui.') {
                $('#editModal').modal('hide');
                $('.modal-backdrop').remove();
                $('#transaksi-table').DataTable().ajax.reload();
                alert(response.message);
            } else {
                alert('Gagal memperbarui transaksi.');
            }
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            if (errors) {
                Object.keys(errors).forEach(function(key) {
                    alert(errors[key][0]);
                });
            }
        }
    });
});
// delete
        $(document).on('click', '.delete-btn', function() {
        var transaksiId = $(this).data('id');
        if (confirm('Are you sure you want to delete this transaksi?')) {
            $.ajax({
                url: '/transaksi/' + transaksiId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    alert(response.message);
                    table.ajax.reload();
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
                }
            });
        }
    });





    });
</script>
