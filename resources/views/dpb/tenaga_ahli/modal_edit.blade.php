@foreach(DB::select("SELECT *, (SELECT nama_lengkap FROM person_personal_data JOIN tenaga_ahli ON
tenaga_ahli.id_person = person_personal_data.id_person WHERE tenaga_ahli.id_tenaga_ahli =
tenaga_ahli_proyek_berjalan.id_tenaga_ahli) AS nama_lengkap

FROM tenaga_ahli_proyek_berjalan
LEFT JOIN proyek_berjalan_uraian_tugas ON tenaga_ahli_proyek_berjalan.id_tg_ahli_proyek_berjalan =
proyek_berjalan_uraian_tugas.id_tg_ahli_proyek_berjalan
WHERE id_dpb = $id") as $row)
<div class="modal fade" id="edit_tenaga_ahli{{$row->id_tg_ahli_proyek_berjalan}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Tenaga
                    Ahli{{$row->id_tg_ahli_proyek_berjalan}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">


                <form class="form_default" method="POST"
                    action="{{url('dpb/edit-tenaga-ahli/' . $row->id_tg_ahli_proyek_berjalan)}}">
                    @csrf

                    <input name="id_dpb" value="{{$id}}" hidden>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Tenaga Ahli <b
                                class="text-danger">*</b></label>
                        <div class="col-9">
                            <select class="form-control" name="id_tenaga_ahli" required>
                                @foreach(DB::select("SELECT *
                                FROM tenaga_ahli
                                JOIN person_personal_data ON tenaga_ahli.id_person =
                                person_personal_data.id_person") as $value)
                                <option value="{{$value->id_tenaga_ahli}}"
                                    {{$row->id_tenaga_ahli == $value->id_tenaga_ahli ? 'selected' : ''}}>
                                    {{$value->nama_lengkap}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Posisi Pekerjaan <b
                                class="text-danger">*</b></label>
                        <div class="col-9">
                            <input class="form-control" name="posisi_pekerjaan" value="{{$row->posisi_pekerjaan}}"
                                required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Lead <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <small class="text-info">Apakah tenaga ahli ini diposisikan sebagai Lead
                                ? Satu pekerjaan memiliki 1 lead tenaga ahli</small>

                            <select class="form-control" name="is_lead" required>
                                <option value="1" {{$row->is_lead == 1 ? 'selected' : ''}}>Ya
                                </option>
                                <option value="0" {{$row->is_lead == 0 ? 'selected' : ''}}>Tidak
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Uraian Tugas <b
                                class="text-danger">*</b></label>
                        <div class="col-9">
                            <textarea class="form-control" name="uraian_tugas" rows="5"
                                required>{{$row->uraian_tugas}}</textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Status Kepegawaian
                            dalam perusahaan <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <select class="form-control" name="status_kepegawaian" required>
                                <option value="1" {{$row->status_kepegawaian == 1 ? 'selected' : ''}}>Pegawai
                                    Tetap</option>
                                <option value="2" {{$row->status_kepegawaian == 2 ? 'selected' : ''}}>Pegawai
                                    Non Tetap</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Surat Referensi dari
                            Pengguna Jasa</label>
                        <div class="col-9">
                            <input class="form-control" name="nomor_surat_referensi"
                                value="{{$row->nomor_surat_referensi}}">
                            <small class="text-secondary">** Boleh Dikosongkan, dapat diisi kembali
                                jika surat referensi sudah kembali.</small>
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
@endforeach