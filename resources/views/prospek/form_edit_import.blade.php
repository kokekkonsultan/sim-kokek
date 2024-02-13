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
                    <h4 class="text-primary font-weight-bolder">{{$title}}</h4>
                </div>
            </div>
            <hr>


            <form class="form_default" method="POST" action="{{url('prospek/proses-edit-import/' . Request::segment(3))}}">
                @csrf


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama Pekerjaan /Paket / Nomenklatur <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_pekerjaan" value="{{$rup->nama_pekerjaan}}" id="nama_pekerjaan" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Pagu <b class="text-danger">*</b></label>
                    <div class="col-sm-10 input-group">
                        <div class="input-group-prepend"><span class="input-group-text">Rp.</span></div>
                        <input type="text" name="pagu" value="{{$rup->pagu}}" id="pagu" class="form-control" required="required">

                    </div>
                </div>



                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Jenis Pengadaan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_jenis_pengadaan" value="{{$rup->nama_jenis_pengadaan}}" id="nama_jenis_pengadaan" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Metode Pemilihan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_metode_pengadaan" value="{{$rup->nama_metode_pengadaan}}" id="nama_metode_pengadaan" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Waktu Pemilihan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="waktu_pemilihan_penyedia" value="{{$rup->waktu_pemilihan_penyedia}}" id="waktu_pemilihan_penyedia" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama Instansi <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_instansi" value="{{$rup->nama_instansi}}" id="nama_instansi" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama Organisasi <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_organisasi" value="{{$rup->nama_organisasi}}" id="nama_organisasi" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Alamat Organisasi <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="alamat_organisasi" value="{{$rup->alamat_organisasi}}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Lokasi Pekerjaan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="lokasi_pekerjaan" value="{{$rup->lokasi_pekerjaan}}" id="lokasi_pekerjaan" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Bidang/ Sub Bidang Pekerjaan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_bidang_pekerjaan" value="{{$rup->nama_bidang_pekerjaan}}" id="nama_bidang_pekerjaan" class="form-control" required="required">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Tahun Anggaran <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="tahun_anggaran" value="2024" id="{{$rup->tahun_anggaran}}" class="form-control" required="required">
                    </div>
                </div>

                <br>
                <hr>

                <div class="text-right mt-5">
                    <a class="btn btn-secondary font-weight-bold" href="{{url('prospek/' . Session::get('id_users'))}}">Kembali</a>
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>

                </div>


            </form>



        </div>
    </div>
</div>


@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Format mata uang.
        $('#pagu').mask('000.000.000.000', {
            reverse: true
        });
    })
</script>

@endsection 