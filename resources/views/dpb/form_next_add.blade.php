@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />

<style>
.select2-container .select2-selection--single {
    /* height: 35px; */
    font-size: 1rem;
}

.dataTables_length {
    display: none
}

.dataTables_filter {
    display: none
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary" style="border:2px solid #3699FF;">
        <h5 class="text-primary font-weight-bolder" style="padding: 1em">PEKERJAAN<br>{!!
            strtoupper($dpb->nama_pekerjaan) !!}</h5>
    </div>

    <div class="alert alert-custom alert-notice alert-light-info fade show mb-5 mt-5" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            <span>Lengkapi pengisian DPB pada formulir dibawah ini.</span>
        </div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>


    @php
    $a = 1;
    $b = 1;
    $c = 1;
    @endphp
    <!-- TERMIN PEMBAYARAN -->
    <div class="card card-body mt-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Termin Pembayaran</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_termin"><i
                        class="fa fa-plus"></i> Tambah Termin Pembayaran</a>
            </div>
        </div>
        <hr>

        <table class="table table-hover table-bordered example" style="width:100%">
            <thead>
                <tr class="bg-secondary">
                    <th width="5%">No</th>
                    <th>%</th>
                    <th>Jumlah</th>
                    <th>Syarat Pembayaran**</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach(DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $id)->get() as $row)
                <tr>
                    <td>{{$a++}}</td>
                    <td>{{$row->persentase_pembayaran}}</td>
                    <td>Rp. {{number_format($row->harga_pembayaran,0,",",".")}}</td>
                    <td>{{$row->syarat_pembayaran}}</td>
                    <td>
                        <button class="btn btn-light-danger btn-icon" href="javascript:void(0)"
                            onclick="delete_termin('{{$row->id_termin_pembayaran}}')"><i
                                class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    <!-- TENAGA AHLI -->
    <div class="card card-body mt-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Tenaga Ahli</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal"
                    data-target="#add_tenaga_ahli"><i class="fa fa-plus"></i> Tambah Tenaga Ahli</a>
            </div>
        </div>
        <hr>

        <table class="table table-hover table-bordered example" style="width:100%">
            <thead>
                <tr class="bg-secondary">
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Lead</th>
                    <th>Uraian Tugas</th>
                    <th>Nomor Surat Referensi</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach(DB::select("SELECT *, (SELECT nama_lengkap FROM person_personal_data JOIN tenaga_ahli ON
                tenaga_ahli.id_person = person_personal_data.id_person WHERE tenaga_ahli.id_tenaga_ahli =
                tenaga_ahli_proyek_berjalan.id_tenaga_ahli) AS nama_lengkap

                FROM tenaga_ahli_proyek_berjalan
                LEFT JOIN proyek_berjalan_uraian_tugas ON tenaga_ahli_proyek_berjalan.id_tg_ahli_proyek_berjalan =
                proyek_berjalan_uraian_tugas.id_tg_ahli_proyek_berjalan
                WHERE id_dpb = $id") as $row)
                <tr>
                    <td>{{$b++}}</td>
                    <td>{{$row->nama_lengkap}}</td>
                    <td>{{$row->posisi_pekerjaan}}</td>
                    <td>{{$row->is_lead == 1 ? 'Ya' : 'Tidak'}}</td>
                    <td>{{$row->uraian_tugas}}</td>
                    <td>{{$row->nomor_surat_referensi}}</td>
                    <td>
                        <a class="btn btn-light-primary btn-icon" data-toggle="modal"
                            data-target="#edit_tenaga_ahli{{$row->id_tg_ahli_proyek_berjalan}}"><i
                                class="fa fa-edit"></i></a>

                        <button class="btn btn-light-danger btn-icon" href="javascript:void(0)"
                            onclick="delete_tenaga_ahli('{{$row->id_tg_ahli_proyek_berjalan}}')"><i
                                class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>





    <!-- OBJEK PEKERJAAN -->
    <div class="card card-body mt-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Objek Pekerjaan</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal"
                    data-target="#add_objek_pekerjaan"><i class="fa fa-plus"></i> Tambah Objek
                    Pekerjaan</a>
            </div>
        </div>
        <hr>

        <table class="table table-hover table-bordered example" style="width:100%">
            <thead>
                <tr class="bg-secondary">
                    <th width="5%">No</th>
                    <th>Objek Pekerjaan</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach(DB::select("SELECT *, (SELECT branch_name FROM branch_agency WHERE id_branch_agency =
                objek_pekerjaan.organization) AS nama_organisasi
                FROM objek_pekerjaan WHERE id_dpb = $id") as $row)
                <tr>
                    <td>{{$c++}}</td>
                    <td>{{$row->nama_organisasi}}</td>
                    <td>
                        <a class="btn btn-light-primary btn-icon" data-toggle="modal"
                            data-target="#edit_objek_pekerjaan{{$row->id_objek_pekerjaan}}"><i
                                class="fa fa-edit"></i></a>

                        @include('dpb/objek_pekerjaan/modal_edit')

                        <button class="btn btn-light-danger btn-icon" href="javascript:void(0)"
                            onclick="delete_objek_pekerjaan('{{$row->id_objek_pekerjaan}}')"><i
                                class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="alert alert-custom alert-notice alert-light-info fade show mb-5 mt-5" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">
                <span>Jika objek pekerjaan sangat banyak, anda bisa mengisi bidang dibawah ini. Namun Anda tetap
                    diwajibkan mengisi bidang Objek Pekerjaan yang asli pada tahap selanjutnya. Bidang ini dipakai agar
                    data pengalaman pekerjaan tidak panjang.</span>
            </div>
        </div>
        <br>


        <form method="POST" action="{{url('dpb/proses-next-add/' . Request::segment(3))}}">
            @csrf

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Persingkat Objek Pekerjaan ? <b
                        class="text-danger">*</b></label>
                <div class="radio-list col-9">
                    <label class="radio radio-primary">
                        <input type="radio" class="font-weight-bold is_objek_pekerjaan_alias"
                            name="is_objek_pekerjaan_alias" value="1" required>
                        <span></span> Ya
                    </label>

                    <label class="radio radio-primary">
                        <input type="radio" class="font-weight-bold is_objek_pekerjaan_alias"
                            name="is_objek_pekerjaan_alias" value="0">
                        <span></span> Tidak
                    </label>
                </div>
            </div>


            <div class="form-group row" id="display_objek_pekerjaan_alias" style="display: none;">
                <label class="col-3 col-form-label font-weight-bold">Nama Objek Pekerjaan Dipersingkat <b
                        class="text-danger">*</b></label>
                <div class="radio-list col-9">
                    <textarea class="form-control" name="objek_pekerjaan_alias" id="objek_pekerjaan_alias"></textarea>
                </div>
            </div>


            <hr>
            <div class="text-right mt-5">
                <a class="btn btn-secondary font-weight-bold"
                    href="{{url('dpb/' . Session::get('id_users'))}}">Kembali</a>
                <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
            </div>

        </form>
    </div>

</div>


@include('dpb/objek_pekerjaan/modal_add')
@include('dpb/objek_pekerjaan/modal_edit')
@include('dpb/tenaga_ahli/modal_add')
@include('dpb/tenaga_ahli/modal_edit')
@include('dpb/termin/modal_add')


@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>

<script>
$(document).ready(function() {
    $('.example').DataTable();
});
</script>

@include('dpb/termin/javascript')
@include('dpb/tenaga_ahli/javascript')
@include('dpb/objek_pekerjaan/javascript')


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
        },
        complete: function() {
            $('.tombolCancel').removeAttr('disabled');
            $('.tombolSubmit').removeAttr('disabled');
            $('.tombolSubmit').html('Simpan');
        },
        success: function(response) {
            Swal.fire(
                'Sukses',
                'Berhasil memproses data.',
                'success'
            );
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(response) {
            // handle error response
            alert('Error memproses data. Hanya ada 1 tenaga ahli lead dalam 1 proyek.');
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        contentType: false,
        processData: false
    });
})
</script>



@endsection