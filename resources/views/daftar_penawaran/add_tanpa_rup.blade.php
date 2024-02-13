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
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}<br>TANPA RENCANA UMUM
            PENGADAAN</h2>
    </div>
    <div class="card card-custom">
        <div class="card-body">


            <form class="form_default" method="POST" action="{{url('daftar-penawaran/add-tanpa-rup')}}">
                @csrf

                <h6 class="text-primary">Informasi Pekerjaan</h6>
                <hr>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Pemberi Kerja / Pengguna Jasa <b
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
                            <option value="{{$row->id_branch_agency}}">
                                {{$row->nama_organisasi_utama . ' - ' . $row->nama_turunan_organisasi . ' - ' . $row->turunan}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Bidang / Sub Bidang Pekerjaan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_bidang_pekerjaan" id="id_bidang_pekerjaan" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM bidang_pekerjaan") as $row)
                            <option value="{{$row->id_bidang_pekerjaan}}">{{$row->nama_bidang_pekerjaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan / Paket / Nomenklatur <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_pekerjaan" required>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Waktu Pemilihan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="bulan_waktu_pemilihan" required>
                            <option value="">Please Select</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" name="tahun_waktu_pemilihan" required>
                            <option value="">Please Select</option>
                            @for ($x = date('Y'); $x <= (date('Y') + 5); $x++) <option value="{{$x}}">{{$x}}</option>
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
                            @for ($x = date('Y'); $x <= (date('Y') + 5); $x++) <option value="{{$x}}">{{$x}}</option>
                                @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Jenis Pengadaan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_kategori_lelang" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM kategori_lelang") as $row)
                            <option value="{{$row->id_kategori_lelang}}">{{$row->nama_kategori_lelang}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Pagu <b class="text-danger">*</b></label>
                    <div class="col-sm-9 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                        </div>
                        <input type="text" class="form-control" name="pagu" id="pagu" required>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Metode Pemilihan <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_metode_pengadaan" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM metode_pengadaan") as $row)
                            <option value="{{$row->id_metode_pengadaan}}">{{$row->nama_metode_pengadaan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <br>
                <br>



                <h6 class="text-primary">Informasi Lelang</h6>
                <hr>
                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Metode Kualifikasi <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_metode_kualifikasi" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM metode_kualifikasi") as $row)
                            <option value="{{$row->id_metode_kualifikasi}}">{{$row->nama_metode_kualifikasi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Metode Dokumen <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_metode_dokumen" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM metode_dokumen") as $row)
                            <option value="{{$row->id_metode_dokumen}}">{{$row->nama_metode_dokumen}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Metode Evaluasi <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="id_metode_evaluasi" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM metode_evaluasi") as $row)
                            <option value="{{$row->id_metode_evaluasi}}">{{$row->nama_metode_evaluasi}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Pembebanan Tahun Anggaran <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9">
                        <select class="form-control" name="pembebanan_tahun_anggaran" required>
                            <option value="">Please Select</option>
                            @for ($x = (date('Y') + 5); $x >= (date('Y') - 1); $x--) <option value="{{$x}}">{{$x}}
                            </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Nilai HPS Paket <b
                            class="text-danger">*</b></label>
                    <div class="col-sm-9 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                        </div>
                        <input type="text" class="form-control" name="nilai_hps" id="nilai_hps" required>
                    </div>
                </div>

                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Pokja</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="pokja" id="pokja">
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT * FROM view_contact_person") as $row)
                            <option value="{{$row->id_contact_person}}">
                                {{$row->contact_person_name . ' (' . $row->occupation . ')'}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <br>
                <br>

                <h6 class="text-primary">Lain-Lain</h6>
                <hr>
                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">PIC <b class="text-danger">*</b></label>
                    <div class="col-sm-9 input-group">
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
                        <!-- <input type="text" class="form-control bg-light" name="pic" value="{{$users->first_name . ' ' . $users->last_name}}" readonly> -->
                    </div>
                </div>


                <div class="form-group row mb-5">
                    <label class="col-sm-3 col-form-label font-weight-bold">Keterangan Lelang</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                        <small class="text-danger">Anda boleh menambahkan keterangan lelang atau catatan pada bidang
                            ini.</small>
                    </div>
                </div>


                <br>
                <hr>

                <div class="text-right mt-5">
                    <a class="btn btn-secondary font-weight-bold"
                        href="{{url('daftar-penawaran/' . Session::get('id_users'))}}">Kembali</a>
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
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>


<script type="text/javascript">
$(document).ready(function() {
    // Format mata uang.
    $('#nilai_hps').mask('000.000.000.000', {
        reverse: true
    });
    $('#pagu').mask('000.000.000.000', {
        reverse: true
    });
})
</script>

<script>
$(document).ready(function() {
    $("#pokja").select2({
        placeholder: "   Please Select",
        allowClear: true,
        closeOnSelect: true,
    });

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

<script>
ClassicEditor
    .create(document.querySelector('#keterangan'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>
@endsection