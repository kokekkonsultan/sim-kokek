@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap"
    rel="stylesheet">


<style>
.select2-container .select2-selection--single {
    /* height: 35px; */
    font-size: 1rem;
}
</style>
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


            <form class="form_default" method="POST" action="{{url('prospek/proses-edit-input/' . Request::segment(3))}}">
                @csrf
                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Organisasi / Instansi Pemberi Kerja <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_branch_agency" id="id_branch_agency" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT id_branch_agency, nama_organisasi_utama,
                            nama_turunan_organisasi,
                            IF(is_organisasi = 1,'[ORGANISASI]','[DATA UNIT]') AS turunan
                            FROM view_organisasi
                            WHERE CASE WHEN is_organisasi = 1 THEN 1 WHEN is_data_unit = 1 THEN 2 ELSE 3 END IN (1,2)")
                            as $row)
                            <option value="{{$row->id_branch_agency}}"
                                {{$rup->organization == $row->id_branch_agency ? 'selected' : ''}}>
                                {{$row->nama_organisasi_utama . ' - ' . $row->nama_turunan_organisasi . ' - ' . $row->turunan}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Bidang/ Sub Bidang Pekerjaan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_bidang_pekerjaan" id="id_bidang_pekerjaan" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM bidang_pekerjaan") as $row)
                            <option value="{{$row->id_bidang_pekerjaan}}"
                                {{$rup->id_bidang_pekerjaan == $row->id_bidang_pekerjaan ? 'selected' : ''}}>
                                {{$row->nama_bidang_pekerjaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan /Paket / Nomenklatur <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{$rup->nama_pekerjaan}}" name="nama_pekerjaan"
                            required>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Jenis Pengadaan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_kategori_lelang" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM kategori_lelang") as $row)
                            <option value="{{$row->id_kategori_lelang}}"
                                {{$rup->id_jenis_pengadaan == $row->id_kategori_lelang ? 'selected' : ''}}>
                                {{$row->nama_kategori_lelang}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Produk Dalam Negeri <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_jenis_produk_rup" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM jenis_produk_rup") as $row)
                            <option value="{{$row->id}}" {{$rup->id_jenis_produk_rup == $row->id ? 'selected' : ''}}>
                                {{$row->nama_jenis_produk_rup}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Usaha Kecil / Koperasi <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_jenis_usaha" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM jenis_usaha") as $row)
                            <option value="{{$row->id}}" {{$rup->id_jenis_usaha == $row->id ? 'selected' : ''}}>
                                {{$row->nama_jenis_usaha}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Waktu Pemilihan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-5">
                        @php
                        $bulan =
                        array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                        $jlh_bln = count($bulan);
                        @endphp
                        <select class="form-control" name="bulan_waktu_pemilihan" required>
                            <option value="">Please Select</option>
                            @for($c=0; $c<$jlh_bln; $c+=1) <option value="Januari"
                                {{$rup->bulan_waktu_pemilihan == $bulan[$c] ? 'selected' : ''}}>{{$bulan[$c]}}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" name="tahun_waktu_pemilihan" required>
                            <option value="">Please Select</option>
                            @for ($x = date('Y'); $x <= (date('Y') + 5); $x++) <option value="{{$x}}"
                                {{$rup->tahun_waktu_pemilihan == $x ? 'selected' : ''}}>{{$x}}</option>
                                @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Tahun Anggaran <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="tahun_anggaran" required>
                            <option value="">Please Select</option>
                            @for ($x = date('Y'); $x <= (date('Y') + 5); $x++) <option value="{{$x}}"
                                {{$rup->tahun_anggaran == $x ? 'selected' : ''}}>{{$x}}</option>
                                @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Lokasi Pekerjaan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{$rup->lokasi_pekerjaan}}"
                            name="lokasi_pekerjaan" required>
                    </div>
                </div>


                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Pagu <b class="text-danger">*</b></label>
                    <div class="col-sm-9 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                        </div>
                        <input type="text" class="form-control" value="{{$rup->pagu}}" name="pagu" id="pagu" required>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Metode Pemilihan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_metode_pengadaan" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM metode_pengadaan") as $row)
                            <option value="{{$row->id_metode_pengadaan}}"
                                {{$rup->id_pemilihan_penyedia == $row->id_metode_pengadaan ? 'selected' : ''}}>
                                {{$row->nama_metode_pengadaan}}</option>
                            @endforeach
                        </select>
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

<script>
$(document).ready(function() {
    $("#id_branch_agency").select2({
        placeholder: "   Please Select",
        allowClear: true,
        closeOnSelect: true,
    });

    $("#id_bidang_pekerjaan").select2({
        placeholder: "   Please Select",
        allowClear: true,
        closeOnSelect: true,
    });
});
</script>

@endsection