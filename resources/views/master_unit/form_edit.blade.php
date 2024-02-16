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
    <div class="card card-custom">
        <div class="card-body">

            <h4 class="text-primary font-weight-bolder">{{strtoupper($title)}}</h4>
            <hr>

            <div class="row mt-10">
                <div class="col-md-6">

                    <form method="POST" action="{{url('master-unit/proses-edit/' . Request::segment(3))}}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Nama Unit <b class="text-danger">*</b>
                                    </label>
                            <input name="branch_name" placeholder="Nama Organisasi" class="form-control" type="text"
                                value="{{$current->nama_organisasi_utama}}" required>
                            <small>(Pemerintah Daerah, Pemerintah Provinsi dan Organisasi Swasta) inputkan secara
                                lengkap nama organisasi. <br />(Kementerian) cukup inputkan nama struktur
                                organisasinya</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Nama Organisasi <b
                                    class="text-danger">*</b></label>
                            <select id="id_suborganization_parent" name="id_suborganization_parent" class="form-control"
                                required></select>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Alamat</label>
                            <textarea name="address" id="address"
                                class="form-control">{!! $current->alamat_organisasi !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Kota / Kabupaten <b
                                    class="text-danger">*</b></label>
                            <select id="id_kota_kab_indonesia" name="id_kota_kab_indonesia" class="form-control"
                                required></select>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Kode Pos</label>
                            <input name="kode_pos" placeholder="Kode Pos" class="form-control" type="number"
                                value="{{$current->kode_pos}}">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Email</label>
                            <input name="email" placeholder="Email" class="form-control" type="email"
                                value="{{$current->email}}">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Telepon</label>
                            <input name="phone" placeholder="Telepon" class="form-control" type="text"
                                value="{{$current->telepon}}">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Website</label>
                            <input name="website" placeholder="Website" class="form-control" type="text"
                                value="{{$current->website}}">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Organisasi Aktif ? <b
                                    class="text-danger">*</b></label>
                            <select name="is_active" class="form-control" required>
                                <option value="1" {{$current->is_active == 1 ? 'selected' : ''}}>Aktif</option>
                                <option value="0" {{$current->is_active == 0 ? 'selected' : ''}}>TIdak Aktif</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Keterangan</label>
                            <textarea name="information" class="form-control"
                                rows="3">{{$current->information}}</textarea>
                        </div>

                        <div class="text-right mt-5">
                            <a class="btn btn-secondary font-weight-bold"
                                href="{{url('master-unit/' . Session::get('id_users'))}}">Batal</a>
                            <button type="submit" class="btn btn-primary font-weight-bold"
                                id="tombolSubmit">Simpan</button>
                        </div>
                    </form>
                </div>



                <div class="col-md-6" style="border-left: 1px dashed #d3d3d3;">

                    <form class="form_default" method="POST" action="{{url('master-unit/proses-add-surat-ditujukan/' . Request::segment(3))}}">
                    @csrf
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-bold">Surat Ditujukan <b class="text-danger">*</b></label>
                            <select name="id_surat_ditujukan" id="id_surat_ditujukan" class="form-control" required></select>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary btn-sm font-weight-bold shadow" type="submit">Tambah</button>
                        </div>
                    </form>

                        <hr>

                        <table class="table table-bordered table-hover mt-5">
                            <tr class="bg-light">
                                <th width="5%" class="text-center">No</th>
                                <th class="text-center">Ditujukan</th>
                                <th width="25%"></th>
                            </tr>

                            @php
                            $no = 1;
                            $organisasi_surat_ditujukan = DB::table('organisasi_surat_ditujukan')
                            ->select('*', 'organisasi_surat_ditujukan.id AS id_organisasi_surat_ditujukan')
                            ->join('surat_ditujukan', 'organisasi_surat_ditujukan.id_surat_ditujukan', '=', 'surat_ditujukan.id')
                            ->where('id_branch_agency', Request::segment(3));
                            @endphp
                            @foreach($organisasi_surat_ditujukan->get() as $row)
                            <tr>
                                <td class="text-center">{{$no++}}</td>
                                <td>{{$row->nama_susunan_organisasi . ' (' . $row->nama_surat_ditujukan . ')'}}</td>
                                <td><a class="btn btn-light-danger btn-sm font-weight-bold" href="javascript:void(0)" class="navi-link" onclick="delete_data('{{$row->id_organisasi_surat_ditujukan}}')"><i class="fa fa-trash"></i> Hapus</a></td>
                            </tr>
                            @endforeach
                        </table>

                        <br/>

                        <a class="btn btn-light-primary shadow font-weight-bold" href="{{url('master-unit/' . Session::get('id_users'))}}"><i class="fas fa-check"></i> Oke</a>
                    
                </div>
            </div>


        </div>
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
$('#id_surat_ditujukan').select2({
    placeholder: "Choose tags..."
});

$(document).ready(function() {
    var $newOption = $("<option selected='selected'></option>").val('{{ $current->id_parent }}').text(
        '{{ $current->nama_turunan_organisasi }}')
    $("#id_suborganization_parent").append($newOption).trigger('change');

    var $newOption2 = $("<option selected='selected'></option>").val('{{ $current->id_kota_kab_indonesia }}')
        .text('{{ $current->nama_kota_kabupaten }}')
    $("#id_kota_kab_indonesia").append($newOption2).trigger('change');
});
</script>

<script>
$('#id_suborganization_parent').select2({
    placeholder: "Please Select",
    minimumInputLength: 2,
    ajax: {
        url: "{{url('select-filter/ajax_organisasi')}}",
        dataType: 'json',
        data: function(params) {
            return {
                q: $.trim(params.term)
            };
        },
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

$('#id_kota_kab_indonesia').select2({
    placeholder: "Please Select",
    minimumInputLength: 2,
    ajax: {
        url: "{{url('select-filter/ajax_kota_kabupaten')}}",
        dataType: 'json',
        data: function(params) {
            return {
                q: $.trim(params.term)
            };
        },
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

$('#id_surat_ditujukan').select2({
    placeholder: "Please Select",
    ajax: {
        url: "{{url('select-filter/ajax_surat_ditujukan')}}",
        dataType: 'json',
        data: function(params) {
            return {
                q: $.trim(params.term)
            };
        },
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
});
</script>

<script>
ClassicEditor
    .create(document.querySelector('#address'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });
</script>


<script>
    function delete_data(id) {
        if (confirm('Anda akan menghapus data ini ?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('master-unit/delete-surat-kepada')}}/" + id,
                dataType: "JSON",
                success: function(data) {
                    if (data.status === true) {
                        toastr["success"]('Berhasil menghapus data');
                        window.setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }

                    if (data.status === false) {
                        Swal.fire('Error', 'Tidak dapat menghapus data!', 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error deleting data');
                }
            });
        }
    }
</script>
@endsection