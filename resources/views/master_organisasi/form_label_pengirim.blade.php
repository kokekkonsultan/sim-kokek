@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-secondary mb-5">
        <h2 class="font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}</h2>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card card-body">

                <h5 class="text-primary font-weight-bolder">PT. KOKEK</h5>
                <hr>

                <form class="form_default" method="GET" action="{{url('master-organisasi/proses-label-pengirim')}}" target="_blank">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Pengirim <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <input type="text" name="pengirim" class="form-control" required="required" placeholder="PT. KOKEK" value="PT. KOKEK">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Handphone <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <input type="text" name="handphone" class="form-control" required="required" placeholder="0895-2681-4555" value="0895-2681-4555">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Alamat <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <textarea name="alamat" class="form-control" id="alamatKokek"><b>Prapen Indah J-12 A Surabaya - 60299<br>Hotline. 0895-2681-4555<br>Email. info@kokek.com</b></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Jumlah <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <div class="input-group">
                                <input type="number" name="jumlah" class="form-control" required="required" placeholder="10" value="10">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Label di Cetak</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Border <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <label><input type="radio" name="with_border" value="true" checked> Dengan
                                Border</label><br>
                            <label><input type="radio" name="with_border" value="false"> Tanpa Border</label>
                        </div>
                    </div>


                    <hr>
                    <div class="text-right">
                        <a class="btn btn-secondary font-weight-bold" href="{{url('master-organisasi/' . Session::get('id_users'))}}">Kembali</a>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="tombolSubmit">Proses</button>
                    </div>
                </form>
            </div>
        </div>



        <div class="col-6">
            <div class="card card-body">

                <h5 class="text-warning font-weight-bolder">PT. CHESNA</h5>
                <hr>
                <form class="form_default" method="GET" action="{{url('master-organisasi/proses-label-pengirim')}}" target="_blank">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Pengirim <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <input type="text" name="pengirim" class="form-control" required="required" placeholder="PT. CHESNA" value="PT. CHESNA">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Handphone <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <input type="text" name="handphone" class="form-control" required="required" placeholder="0896-7478-3377" value="0896-7478-3377">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Alamat <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <textarea name="alamat" class="form-control" id="alamatChensa"><b>Gedung Papaya Lt. 2<br>Jl. Raya Margorejo Indah 60-68<br>Surabaya- 60238<br>Hotline. 0896-7478-3377<br>Email. info@chesna.co.id</b></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Jumlah <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <div class="input-group">
                                <input type="number" name="jumlah" class="form-control" required="required" placeholder="10" value="10">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Label di Cetak</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label font-weight-bold">Border <b class="text-danger">*</b></label>
                        <div class="col-10">
                            <label><input type="radio" name="with_border" value="true" checked> Dengan
                                Border</label><br>
                            <label><input type="radio" name="with_border" value="false"> Tanpa Border</label>
                        </div>
                    </div>


                    <hr>
                    <div class="text-right">
                        <a class="btn btn-secondary font-weight-bold" href="{{url('master-organisasi/' . Session::get('id_users'))}}">Kembali</a>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="tombolSubmit">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>


@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>


<script>
    ClassicEditor
        .create(document.querySelector('#alamatKokek'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#alamatChensa'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection