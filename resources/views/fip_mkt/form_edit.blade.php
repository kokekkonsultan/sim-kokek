@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{!! strtoupper('Edit Formulir Informasi
            Pekerjaan') !!}</h2>
    </div>

    <div class="card card-body">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Deskripsi Pekerjaan</h6>
            </div>
        </div>
        <hr>


        <div class="form-group row mb-5">
            <label class="col-sm-3 col-form-label font-weight-bold">Kode Proyek <b class="text-danger">*</b></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="{{$fip->kode}}" disabled>
            </div>
        </div>

        <div class="form-group row mb-5">
            <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan <b class="text-danger">*</b></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="nama_pekerjaan" value="{{$fip->nama_pekerjaan}}" disabled>
            </div>
        </div>

        <div class="form-group row mb-5">
            <label class="col-sm-3 col-form-label font-weight-bold">Durasi Pekerjaan <b
                    class="text-danger">*</b></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="durasi_kontrak_pekerjaan"
                    value="{{$fip->durasi_kontrak_pekerjaan}}" disabled>
            </div>
        </div>

        <div class="form-group row mb-5">
            <label class="col-sm-3 col-form-label font-weight-bold">Pemberi Kerja <b class="text-danger">*</b></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="nama_pemberi_kerja" value="{{$fip->pemberi_kerja}}"
                    disabled>
            </div>
        </div>


        <div class="form-group row mb-5">
            <label class="col-sm-3 col-form-label font-weight-bold">Tenaga Ahli (Lead) <b
                    class="text-danger">*</b></label>
            <div class="col-sm-9">
                @php
                $tg = collect(DB::select("SELECT *,
                (SELECT nama_lengkap FROM tenaga_ahli JOIN person_personal_data ON tenaga_ahli.id_person =
                person_personal_data.id_person WHERE tenaga_ahli.id_tenaga_ahli =
                tenaga_ahli_proyek_berjalan.id_tenaga_ahli) AS nama_lengkap

                FROM tenaga_ahli_proyek_berjalan
                WHERE is_lead = 1 && id_dpb = $fip->id_dpb"));
                @endphp
                <input type="text" class="form-control" id="tenaga_ahli_lead"
                    value="{{$tg->count() > 0 ? $tg->first()->nama_lengkap : ''}}" disabled>
            </div>
        </div>

        <div class="form-group row mb-5">
            <label class="col-sm-3 col-form-label font-weight-bold">Contact Person <b class="text-danger">*</b></label>
            <div class="col-sm-9">
                @php
                if($fip->id_ppk != 0){
                $cp = $fip->nama_ppk . ' (' . implode(", ", unserialize($fip->phone_ppk)) . ')';
                } elseif($fip->id_pptk != 0){
                $cp = $fip->nama_pptk . ' (' . implode(", ", unserialize($fip->phone_pptk)) . ')';
                } elseif($fip->id_kpa != 0){
                $cp = $fip->nama_kpa . ' (' . implode(", ", unserialize($fip->phone_kpa)) . ')';
                } else {
                $cp = $fip->nama_pa . ' (' . implode(", ", unserialize($fip->phone_pa)) . ')';
                }
                @endphp

                <input type="text" class="form-control" id="contact_person" value="{{$cp}}" disabled>
            </div>
        </div>


        <div class="form-group row mb-5">
            <label class="col-sm-3 col-form-label font-weight-bold">Jumlah Termin Pembayaran <b
                    class="text-danger">*</b></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="jumlah_termin_pembayaran"
                    value="{{DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $fip->id_dpb)->count()}}"
                    disabled>
            </div>
        </div>
    </div>




    <form class="form_default" method="POST" action="{{url('fip-mkt/proses-edit/' . $fip->id_fip)}}">
        @csrf

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
                            <input type="radio" name="ruang_lingkup_pekerjaan_seluruh" value="1" required
                                {{$fip->ruang_lingkup_pekerjaan_seluruh == 1 ? 'checked' : ''}}><span></span>Seluruh
                        </label>
                        <label class="radio">
                            <input type="radio" name="ruang_lingkup_pekerjaan_seluruh" value="0"
                                {{$fip->ruang_lingkup_pekerjaan_seluruh == 0 ? 'checked' : ''}}><span></span>Sebagian
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Sebutkan Ruang Lingkup</label>
                <div class="col-9">
                    <textarea name="sebutkan_ruang_lingkup" rows="5"
                        class="form-control form-control">{{$fip->sebutkan_ruang_lingkup}}</textarea>
                </div>
            </div>

            <!-- <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Upload File Berita Acara Negosiasi</label>
                <div class="col-9">
                    <input type="file" name="file">
                    <br>
                    <small class="text-danger">** Format file harus pdf dan Ukuran max file adalah 10MB.</small>
                </div>
            </div> -->

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">PIC Marketing <b class="text-danger">*</b></label>
                <div class="col-9">

                    <select class="form-control" name="id_marketing" id="id_marketing" required>
                        <option value="">Please Select</option>

                        @foreach(DB::table('person_personal_data')->get() as $row)
                        <option value="{{$row->id_person}}" {{$row->id_person == $fip->id_marketing ? 'selected' : ''}}>
                            {{$row->nama_lengkap}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>


        <div class="text-right mt-5">
            <a class="btn btn-secondary font-weight-bold"
                href="{{url('fip-mkt/' . Session::get('id_users'))}}">Kembali</a>
            <button type="submit" class="btn btn-primary font-weight-bold">Selanjutnya</button>
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