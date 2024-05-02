@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{!! strtoupper('Tambah Formulir Informasi
            Pekerjaan') !!}</h2>
    </div>

    <form class="form_default" method="POST" action="{{url('fip-mkt/proses-add')}}" role="form"
        enctype="multipart/form-data">
        @csrf

        <div class="card card-body">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Deskripsi Pekerjaan</h6>
                </div>
            </div>
            <hr>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Pilih DPB <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control" name="id_dpb" id="id_dpb" required autofocus>
                        <option value="">Please Select</option>

                        @foreach(DB::select("SELECT id_dpb, kode_dpb,
                        IF(id_jenis_pekerjaan = 1, (SELECT nama_pekerjaan FROM data_dil_marketing WHERE
                        data_dil_marketing.id_dil = daftar_proyek_berjalan.id_dil), nama_pekerjaan) AS
                        nama_pekerjaan_dpb

                        FROM daftar_proyek_berjalan
                        WHERE NOT EXISTS (SELECT * FROM formulir_informasi_pekerjaan WHERE
                        formulir_informasi_pekerjaan.id_dpb = daftar_proyek_berjalan.id_dpb)") as $value)

                        <option value="{{$value->id_dpb}}">
                            {{'(' . $value->kode_dpb . ') ' . $value->nama_pekerjaan_dpb}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Kode Proyek <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control bg-light" id="kode_dpb" name="kode_dpb" readonly>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_pekerjaan" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Durasi Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="durasi_kontrak_pekerjaan" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Pemberi Kerja <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_pemberi_kerja" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Jumlah Termin Pembayaran <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="jumlah_termin_pembayaran" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Tenaga Ahli (Lead) <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="tenaga_ahli_lead" disabled>
                </div>
            </div>
        </div>





        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Lain-lain</h6>
                </div>
            </div>
            <hr>
            <br>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Ruang Lingkup <b class="text-danger">*</b></label>
                <div class="col-9">
                    <div class="radio-list">
                        <label class="radio">
                            <input type="radio" name="ruang_lingkup_pekerjaan_seluruh" value="1"
                                required><span></span>Seluruh
                        </label>
                        <label class="radio">
                            <input type="radio" name="ruang_lingkup_pekerjaan_seluruh" value="0"><span></span>Sebagian
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Sebutkan Ruang Lingkup</label>
                <div class="col-9">
                    <textarea name="sebutkan_ruang_lingkup" rows="5" class="form-control form-control"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Upload File Berita Acara Negosiasi</label>
                <div class="col-9">
                    <input type="file" name="file" required>
                    <br>
                    <small class="text-danger">** Format file harus pdf dan Ukuran max file adalah 10MB.</small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">PIC Marketing <b class="text-danger">*</b></label>
                <div class="col-9">

                    <select class="form-control" name="id_marketing" id="id_marketing" required>
                        <option value="">Please Select</option>

                        @foreach(DB::table('person_personal_data')->get() as $row)
                        <option value="{{$row->id_person}}">{{$row->nama_lengkap}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>


        <div class="text-right mt-5">
            <a class="btn btn-secondary font-weight-bold"
                href="{{url('fip-mkt/' . Session::get('id_users'))}}">Kembali</a>
            <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>

        </div>
    </form>


</div>


@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif

<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>

<script>
$('#id_marketing').select2({
    placeholder: "Please Select",
    width: '100%'
});
$('#id_dpb').change(function() {
    var id = $(this).val();
    $.ajax({
        url: "{{ url('fip-mkt/cari-id-dpb') }}/" + id,
        type: 'get',
        dataType: 'json',
        success: function(data) {
            $('#kode_dpb').val('K-' + data.kode_dpb);
            $('#nama_pekerjaan').val(data.nama_pekerjaan);
            $('#durasi_kontrak_pekerjaan').val(data.durasi_kontrak_pekerjaan);
            $('#nama_pemberi_kerja').val(data.nama_pemberi_kerja);
            $('#jumlah_termin_pembayaran').val(data.jumlah_termin_pembayaran);
            $('#tenaga_ahli_lead').val(data.tenaga_ahli_lead);
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    // Format mata uang.
    $('#nilai_pekerjaan').mask('000.000.000.000', {
        reverse: true
    });
})
</script>
@endsection