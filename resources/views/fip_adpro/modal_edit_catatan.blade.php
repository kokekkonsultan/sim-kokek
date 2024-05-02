


@foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 3])->get() as $value)
<div class="modal fade" id="edit_catatan_{{$value->id_catatan_fip}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Edit Catatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST" action="{{url('fip-adpro/edit-catatan/' . $value->id_catatan_fip)}}">
                    @csrf

                    <input name="id_fip" value="{{$value->id_fip}}" hidden>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Tanggal Catatan <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <input class="form-control" type="date" name="tanggal_catatan" value="{{$value->tanggal_catatan}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Isi Catatan <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <textarea class="form-control" name="isi_catatan" id="isi_catatan" rows="4">{{$value->isi_catatan}}</textarea>
                        </div>
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
@endforeach