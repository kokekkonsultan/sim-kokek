@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">
    <div id="cf-response-message"></div>
    <div class="card card-custom">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h4 class="text-primary font-weight-bolder">Form Import</h4>
                </div>
            </div>
            <hr>


            <p>Silahkan anda download file template diatas, kemuadian anda isi sesuai kolom yang disediakan. Pastikan anda mengikuti format pengisian yang ada. Setelah anda isi lakukan proses upload pada form dibawah ini.</p>

            <form class="form_default" method="POST" role="form" enctype="multipart/form-data">
            {{-- <form action="{{url('rup/proses-import/' . Request::segment(3))}}" class="form_default" method="POST" role="form" enctype="multipart/form-data"> --}}
                @csrf
                <div class="form-group">
                    <label class="form-label font-weight-bold">Pilih file excel yang sudah anda isi <span class="text-danger">*</span></label>
                    <br>
                    <input type="file" name="file" required>
                </div>


                <a class="btn btn-secondary btn-sm font-weight-bold tombolCancel" href="{{url('rup/' . Request::segment(3))}}">Kembali</a>
                <button type="submit" class="btn btn-primary btn-sm font-weight-bold tombolSubmit">Upload Data Excel</button>

            </form>

        </div>
    </div>
</div>


@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>


<script>
    $('.form_default').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        // build the ajax call
        $.ajax({
            url: "{{url('rup/proses-import/' . Request::segment(3))}}",
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('.tombolCancel').attr('disabled', 'disabled');
                $('.tombolSubmit').attr('disabled', 'disabled');
                $('.tombolSubmit').html(
                    '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                Swal.fire({
                    title: 'Memproses data',
                    html: 'Mohon tunggu sebentar. Sistem sedang menyiapkan request anda.',
                    allowOutsideClick: false,
                    onOpen: () => {
                        swal.showLoading()
                    }
                });

            },
            complete: function() {
                $('.tombolCancel').removeAttr('disabled');
                $('.tombolSubmit').removeAttr('disabled');
                $('.tombolSubmit').html('Upload Data Excel');
            },
            success: function(response) {
                // handle success response
                toastr["success"]('Data berhasil diuploud');
                window.setTimeout(function() {
                    location.href = "{{url('rup/' . Request::segment(3))}}"
                }, 1500);
                // console.log(response.data);
            },
            error: function(response) {
                // handle error response
                // console.log(response.data);
                alert('Error uploud data!');
            },
            contentType: false,
            processData: false
        });
    })
</script>

@endsection 