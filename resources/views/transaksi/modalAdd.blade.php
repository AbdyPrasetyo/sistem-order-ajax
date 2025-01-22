 <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="addTransaksiForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="suplier">Suplier</label>
                        <select name="suplier_id" class="form-select" required>
                            <option value="">Pilih Suplier</option>
                            @foreach ($suplier as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->kodespl }} [{{ $sup->namaspl }}]</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="suplier_error"></span>
                    </div>

                    <div id="barang-container">
                        <div class="row barang-group">
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
                    </div>

                    <button type="button" class="btn btn-secondary mt-2" id="addBarangBtn">Tambah Barang</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div> 

