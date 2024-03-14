<div class="modal fade" id="add_tenaga_ahli" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tenaga Ahli</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST" action="{{url('dpb/add-tenaga-ahli/' . Request::segment(3))}}">
                    @csrf

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Tenaga Ahli <b
                                class="text-danger">*</b></label>
                        <div class="col-9">
                            <select class="form-control" name="id_tenaga_ahli" id="id_tenaga_ahli" required>
                                <option value="">Please Select</option>

                                @foreach(DB::select("SELECT *
                                FROM tenaga_ahli JOIN person_personal_data ON tenaga_ahli.id_person =
                                person_personal_data.id_person") as $row)
                                <option value="{{$row->id_tenaga_ahli}}">{{$row->nama_lengkap}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Posisi Pekerjaan <b
                                class="text-danger">*</b></label>
                        <div class="col-9">
                            <input class="form-control" name="posisi_pekerjaan" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Lead <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <small class="text-info">Apakah tenaga ahli ini diposisikan sebagai Lead ? Satu pekerjaan
                                memiliki 1 lead tenaga ahli</small>

                            <div class="radio-list">
                                <label class="radio"><input type="radio" name="is_lead" value="1" required><span></span>
                                    Ya</label>
                                <label class="radio"><input type="radio" name="is_lead" value="0"><span></span>
                                    Tidak</label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Uraian Tugas <b
                                class="text-danger">*</b></label>
                        <div class="col-9">
                            <textarea class="form-control" name="uraian_tugas" rows="5" required></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Status Kepegawaian dalam perusahaan <b
                                class="text-danger">*</b></label>
                        <div class="col-9">
                            <div class="radio-list">
                                <label class="radio"><input type="radio" name="status_kepegawaian" value="1"
                                        required><span></span> Pegawai Tetap</label>
                                <label class="radio"><input type="radio" name="status_kepegawaian"
                                        value="2"><span></span> Pegawai Non Tetap</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Surat Referensi dari Pengguna Jasa</label>
                        <div class="col-9">
                            <input class="form-control" name="nomor_surat_referensi">
                            <small class="text-secondary">** Boleh Dikosongkan, dapat diisi kembali jika surat referensi
                                sudah kembali.</small>
                        </div>
                    </div>

                    <br>
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