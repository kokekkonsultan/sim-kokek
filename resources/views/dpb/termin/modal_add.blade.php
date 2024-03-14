<!-- MODAL ADD TERMIN -->
<div class="modal fade" id="add_termin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Termin Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST" action="{{url('dpb/add-termin/' . Request::segment(3))}}">
                    @csrf

                    <div class="form-group row mb-5">
                        <label class="col-3 col-form-label font-weight-bold">Nilai Pekerjaan</label>
                        <div class="col-9 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input class="form-control bg-light" value="{{number_format($dpb->nilai_pekerjaan,0, ',', '.')}}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        <label class="col-3 col-form-label font-weight-bold">Nomor Termin</label>
                        <div class="col-9">
                            <input class="form-control bg-light" name="nomor_termin" value="{{DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $id)->count() + 1}}" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        <label class="col-3 col-form-label font-weight-bold">Persentase <b class="text-danger">*</b></label>
                        <div class="col-9 input-group">
                            <input class="form-control" type="number" step="0.01" name="persentase_pembayaran" id="persentase_pembayaran" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row mb-5">
                        <label class="col-3 col-form-label font-weight-bold">Jumlah <b class="text-danger">*</b></label>
                        <div class="col-9 input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input class="form-control bg-light" name="harga_pembayaran" id="harga_pembayaran" readonly>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        <label class="col-3 col-form-label font-weight-bold">Syarat Pembayaran</label>
                        <div class="col-9">
                            <textarea class="form-control" name="syarat_pembayaran" id="syarat_pembayaran"></textarea>
                            <small class="text-danger">** Diisi Syarat Jatuh Tempo Termin. Contoh Apabila Pekerjaan
                                Telah Selesai 20%</small>
                        </div>
                    </div>


                    <hr>

                    <div class="text-right">
                        <button type="button" class="btn btn-secondary tombolCancel" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary font-weight-bold tombolCancel" type="submit">Simpan</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>