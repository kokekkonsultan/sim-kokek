@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="container-fluid">

    <div class="card card-custom">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h4 class="text-primary font-weight-bolder">{{strtoupper($title)}}</h4>
                </div>
            </div>

            <hr>
            <br>

            <form class="form_default" method="POST" action="{{url('pic-wilayah-marketing/proses-add')}}">
                @csrf

                <div class="form-group row mb-5">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama PIC <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-10 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                        </div>
                        <select class="form-control" name="pic" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT users.id AS users_id, CONCAT(users.first_name, ' ',
                            users.last_name) AS users_name
                            FROM users
                            JOIN users_groups ON users_groups.user_id = users.id
                            JOIN groups ON groups.id = users_groups.group_id
                            WHERE groups.name = 'marketing' AND users.active = 1") as $row)
                            <option value="{{$row->users_id}}">{{$row->users_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br />

                <div class="form-group row mb-5">
                    <label class="col-sm-2 col-form-label font-weight-bold">WIlayah PIC <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-10">


                        <div class="control-group after-add-more">
                            <div class="form-group row">
                                <div class="col-sm-11">
                                    <input type="text" name="nama_wilayah[]" class="form-control"
                                        placeholder="Detail wilayah cakupan . . .">
                                </div>
                                <div class="input-group-addon col-sm-1">
                                    <button class="btn btn-success add-more" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- class hide membuat form disembunyikan  -->
                        <!-- hide adalah fungsi bootstrap 3, klo bootstrap 4 pake invisible  -->
                        <div class="copy" style="display:none">
                            <div class="control-group row mb-7">
                                <div class="col-sm-11">
                                    <input type="text" name="nama_wilayah[]" class="form-control"
                                        placeholder="Detail wilayah cakupan . . .">
                                </div>
                                <div class="input-group-addon col-sm-1">
                                    <button class="btn btn-danger remove" type="button">
                                        <i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <br>
                <hr>

                <div class="text-right mt-5">
                    <a class="btn btn-secondary font-weight-bold" href="{{url('pic-wilayah-marketing/' . Session::get('id_users'))}}">Kembali</a>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div>


@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    var maxGroup = 10;

    $(".add-more").click(function() {
        // if ($('body').find('.after-add-more').length < maxGroup) {
        //     var html = '<div class="control-group after-add-more">' + $(".copy").html() +
        //         '</div>';
        //     $('body').find('.after-add-more:last').after(html);
        // } else {
        //     alert('Maximum ' + maxGroup + ' groups are allowed.');
        // }

        var html = '<div class="control-group after-add-more">' + $(".copy").html() + '</div>';
        $('body').find('.after-add-more:last').after(html);
    });

    // saat tombol remove dklik control group akan dihapus 
    $("body").on("click", ".remove", function() {
        $(this).parents(".control-group").remove();
    });

});
</script>
@endsection