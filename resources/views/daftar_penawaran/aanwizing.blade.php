@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light mb-5" style="border:2px solid #acd3fa;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}</h2>
    </div>
    <div class="card card-body">

        <h5 class="text-primary">Detail Pekerjaan</h5>
        <hr>


        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Nama Pekerjaan</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{{$dil->nama_pekerjaan}}</div>
        </div>


        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Nama Pemberi Kerja</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{{$dil->pemberi_kerja}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Metode Pengadaan</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{{$dil->nama_metode_pengadaan}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Metode Kualifikasi</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{{$dil->nama_metode_kualifikasi}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Metode Dokumen</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{{$dil->metode_dokumen}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Metode Evaluasi</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{{$dil->nama_metode_evaluasi}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Pagu</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9" id="pagu">{{number_format($dil->pagu,0,",",".")}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Nilai HPS Paket</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9" id="nilai_hps">{{number_format($dil->nilai_hps,0,",",".")}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">PIC</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{{$dil->nama_pic_dil}}</div>
        </div>



        <div class="row">
            <label class="col-sm-2 col-form-label font-weight-bolder">Hasil Lelang</label>
            <div class="col-1 font-weight-bolder">:</div>
            <div class="col-sm-9">{!! $status !!}</div>
        </div>


    </div>


    <div class="card card-body mt-5">


        <form class="form_default" method="POST" action="{{url('daftar-penawaran/publish-aanwizing/' . Request::segment(3))}}">
            @csrf

            <h5 class="text-primary">Uraian</h5>
            <hr>

            <div class="row mb-5">
                <div class="col-6">
                    <label class="col-form-label font-weight-bold">Jenis Kontrak <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="jenis_kontrak" value="{{$dil->jenis_kontrak}}" placeholder="Masukkan jenis kontrak.." required autofocus>
                </div>
                <div class="col-6">
                    <label class="col-form-label font-weight-bold">Nilai Ambang Batas Evaluasi Teknis <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="nilai_batas_evaluasi" placeholder="Masukkan Nilai Ambang Batas Evaluasi Teknis.." value="{{$dil->nilai_batas_evaluasi}}" required>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-6">
                    <label class="col-form-label font-weight-bold">Bobot Teknis <b class="text-danger">*</b></label>
                    <input type="number" class="form-control" name="bobot_teknis" value="{{$dil->bobot_teknis}}" placeholder="Masukkan Bobot Teknis.." required>
                </div>
                <div class="col-6">
                    <label class="col-form-label font-weight-bold">Bobot Biaya <b class="text-danger">*</b></label>
                    <input type="number" class="form-control" name="bobot_biaya" value="{{$dil->bobot_biaya}}" placeholder="Masukkan Bobot Biaya.." required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-form-label font-weight-bolder">Uraian dan Pertanyaan Aanwizing <b class="text-danger">*</b></label>
                <textarea class="form-control" name="uraian_aanwizing" id="uraian_aanwizing">{!! $dil->uraian_aanwizing !!}</textarea>
                <small class="text-danger">Anda bisa menambahkan uraian dan pertanyaan aanwizing pada bidang
                    ini.</small>
            </div>


            <div class="text-center">
                <a class="btn btn-secondary btn-lg font-weight-bolder tombolCancel" href="{{url('daftar-penawaran/' . Session::get('id_users'))}}"><i class="fa fa-arrow-left"></i>Kembali</a>

                <button type="submit" onclick="return confirm('Apakah anda yakin ingin mempublish data aanwizing ?')" class="btn btn-success btn-lg font-weight-bolder tombolSubmit"><i class="fa fa-share"></i> Publish Aanwizing</button>
            </div>

        </form>
    </div>
</div>



@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#uraian_aanwizing'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>


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
                $('.tombolSubmit').html('<i class="fa fa-share"></i> Publish Aanwizing');
            },
            success: function(response) {
                Swal.fire(
                    'Sukses',
                    'Berhasil mem-pulish Aanwezing.',
                    'success'
                );
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            },
            error: function(response) {
                // handle error response
                alert('Error publish data!');
            },
            contentType: false,
            processData: false
        });
    })
</script>


@endsection