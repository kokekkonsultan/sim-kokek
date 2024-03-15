<div class="modal fade" id="add_objek_pekerjaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Objek Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST"
                    action="{{url('dpb/add-objek-pekerjaan/' . Request::segment(3))}}">
                    @csrf

                    <div class="form-group row mb-5">
                        <label class="col-sm-3 col-form-label font-weight-bold">Objek Pekerjaan <b
                                class="text-danger">*</b></label>
                        <div class="col-sm-9">
                            <select class="form-control organization" name="organization" required></select>
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