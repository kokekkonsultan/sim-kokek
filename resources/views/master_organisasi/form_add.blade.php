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

            <form class="form_default" method="POST" action="{{url('master-organisasi/proses-add')}}">
                @csrf
                <h4 class="text-primary font-weight-bolder">{{strtoupper($title)}}</h4>
                <hr>

                <div class="row mt-10">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-weight-bold">Nama Organisasi <bclass="text-danger">*</bclass=></label>
                            <input name="branch_name" placeholder="Nama Organisasi" class="form-control" type="text" required>
                            <small>(Pemerintah Daerah, Pemerintah Provinsi dan Organisasi Swasta) inputkan secara
                                lengkap nama organisasi. <br />(Kementerian) cukup inputkan nama struktur
                                organisasinya</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Nama Instansi <b class="text-danger">*</b></label>
                            <select id="id_suborganization_parent" name="id_suborganization_parent" class="form-control" required></select>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Alamat</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                            <small>Break: Gunakan Shift+Enter</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Kota / Kabupaten <b class="text-danger">*</b></label>
                            <select id="id_kota_kab_indonesia" name="id_kota_kab_indonesia" class="form-control" required></select>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Kode Pos</label>
                            <input name="kode_pos" placeholder="Kode Pos" class="form-control" type="number">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Email</label>
                            <input name="email" placeholder="Email" class="form-control" type="email">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Telepon</label>
                            <input name="phone" placeholder="Telepon" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Website</label>
                            <input name="website" placeholder="Website" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Organisasi Aktif ? <b
                                    class="text-danger">*</b></label>
                            <select name="is_active" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="1">Aktif</option>
                                <option value="0">TIdak Aktif</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-bold">Keterangan</label>
                            <textarea name="information" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6" style="border-left: 1px dashed #d3d3d3;">
                        <div class="form-group">
                            <label class="form-label font-weight-bold">Surat Ditujukan <b
                                    class="text-danger">*</b></label><br>
                            <hr>
                            @foreach (DB::table('surat_ditujukan')->get() as $element)
                            <label>
                                <input type="checkbox" name="surat_ditujukan[]" value="{{ $element->id }}">
                                {!! $element->nama_susunan_organisasi . ' <b>(' . $element->nama_surat_ditujukan .
                                    ')</b>' !!}
                            </label><br />
                            @endforeach
                        </div>
                    </div>
                </div>

                <hr>
                <div class="text-right">
                    <a class="btn btn-secondary font-weight-bold" href="{{url('master-organisasi/' . Session::get('id_users'))}}">Batal</a>
                    <button type="submit" class="btn btn-primary font-weight-bold" id="tombolSubmit">Simpan</button>
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

<script>
    $('#id_suborganization_parent').select2({
            placeholder: "Please Select",
            minimumInputLength: 2,
            ajax: {
                url: "{{url('select-filter/ajax_instansi')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
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
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $(document).ready(function() {
            $('#tombolSubmit').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if (!checked) {
                    alert("Anda harus mencentang setidaknya satu organisasi.");
                    return false;
                }
            });
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
@endsection