<!-- MODAL ADD BIAYA -->
<div class="modal fade" id="add_biaya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Biaya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST" action="{{url('fip-mkt/add-biaya')}}">
                    @csrf

                    <input name="id_fip" value="{{$fip->id_fip}}" hidden>
                    <div class="mb-3">
                        <label class="col-form-label font-weight-bold">Jenis Biaya <b class="text-danger">*</b></label>
                        <select class="form-control" name="id_jenis_fip_biaya" required>
                            <option value="">Please Select</option>
                            <option value="1">Biaya Personil</option>
                            <option value="2">Biaya Non Personil</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label font-weight-bold">Uraian <b class="text-danger">*</b></label>
                        <input class="form-control" name="uraian" placeholder="Masukkan uraian biaya, Contoh : Biaya Akomodasi / Biaya Cetak Sertifikat" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Volume 1 <b class="text-danger">*</b></label>
                            <input class="form-control hitung" type="number" name="volume1" id="volume1" placeholder="Contoh : 4" required>
                        </div>
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Satuan 1 <b class="text-danger">*</b></label>
                            <input class="form-control" type="text" name="satuan1" placeholder="Contoh : Orang" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Volume 2</label>
                            <input class="form-control hitung" type="number" placeholder="Contoh : 2" name="volume2" id="volume2">
                        </div>
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Satuan 2</label>
                            <input class="form-control" type="text" placeholder="Contoh : Kamar, dll." name="satuan2">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Volume 3</label>
                            <input class="form-control hitung" type="number" name="volume3" id="volume3">
                        </div>
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Satuan 3</label>
                            <input class="form-control" type="text" name="satuan3">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Harga Satuan <b class="text-danger">*</b></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                </div> 
                                <input class="form-control hitung" type="number" name="harga_satuan" id="harga_satuan" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="col-form-label font-weight-bold">Jumlah <b class="text-danger">*</b></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                </div> 
                                <input class="form-control" type="text" name="jumlah" id="jumlah" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label font-weight-bold">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="4"></textarea>
                    </div>


                    <hr>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary tombolCancel" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary font-weight-bold tombolSubmit" type="submit">Simpan</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
