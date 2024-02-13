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
                    <h4 class="text-primary font-weight-bolder">Form Preview</h4>
                    <p>Data yang anda upload</p>
                </div>
            </div>
            <hr>




            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%">
                    <tr>
                        <th>#</th>
                        <th>Paket</th>
                        <th>Pagu (Rp)</th>
                        <th>Jenis Pengadaan</th>
                        <th>Produk Dakam Negeri</th>
                        <th>Usaha Kecil/ Koperasi</th>
                        <th>Metode</th>
                        <th>Pemilihan</th>
                        <th>K/L/PD</th>
                        <th>Satuan Kerja</th>
                        <th>Lokasi</th>
                        <th>ID</th>
                    </tr>
                    {!! $table !!}
                </table>
            </div>

            <br>
            <p class="font-weight-bold text-danger">Jika data yang ditampilkan diatas sesuai yang anda inginkan, anda bisa langsung menekan tombol dibawah ini untuk menyimpan.</p>


            <form class="form_default" action="{{url('rup/proses-import/' . Request::segment(3))}}" method="POST">
                <!-- <form action="{{url('rup/proses-import/' . Request::segment(3))}}" method="POST"> -->
                @csrf
                <input type="text" name="namafile" value="{{ $nama_file_baru }}" hidden>

                <hr>

                <div class="text-left mt-3">
                    <a class="btn btn-secondary font-weight-bold tombolCancel" href="{{url('rup/form-import/' . Request::segment(3))}}">Kembali</a>
                    <button type="submit" class="btn btn-primary font-weight-bold tombolSubmit">Upload Data</button>
                </div>
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
            url: $(this).attr('action'),
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
                }, 1000);
                // console.log(response.data);
            },
            error: function(response) {
                // handle error response
                alert('Error uploud data!');
                console.log(response.data);
            },
            contentType: false,
            processData: false
        });
    })
</script>
@endsection 