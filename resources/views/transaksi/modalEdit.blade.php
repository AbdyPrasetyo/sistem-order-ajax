<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="editTransaksiForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editTransaksiId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="suplier">Suplier</label>
                        <select name="suplier_id" id="editSuplier" class="form-select" required>
                            <option value="">Pilih Suplier</option>
                            @foreach ($suplier as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->kodespl }} [{{ $sup->namaspl }}]</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="edit_suplier_error"></span>
                    </div>

                    <div id="edit-barang-container"></div>

                    <button type="button" class="btn btn-secondary mt-2" id="addEditBarangBtn">Tambah Barang</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
