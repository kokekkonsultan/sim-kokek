<!-- MODAL ADD -->
<div class="modal fade" id="add_catatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Catatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST" action="{{url('fip-adpro/add-catatan')}}">
                    @csrf

                    <input name="id_fip" value="{{$fip->id_fip}}" hidden>
                    <input name="jenis_catatan" value="3" hidden>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Tanggal Catatan <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <input class="form-control" type="date" name="tanggal_catatan" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Isi Catatan <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <textarea class="form-control" name="isi_catatan" id="isi_catatan" rows="4"></textarea>
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