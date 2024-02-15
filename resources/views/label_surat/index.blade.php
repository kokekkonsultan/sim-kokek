@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">

    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}</h2>
    </div>

    <div class="card card-body mb-5">

        <h5 class="text-primary">Filter Data</h5>
        <hr>
        <br>


        <form id="form-filter">
            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Kategori Instansi</label>
                <div class="col-10">
                    <select id="id_agency_category" name="id_agency_category" class="form-control" multiple="multiple"></select>
                </div>
            </div>


            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Instansi</label>
                <div class="col-10">
                    <select id="id_agency" name="id_agency" class="form-control" multiple="multiple"></select>
                </div>
            </div>


            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Organisasi</label>
                <div class="col-10">
                    <select id="id_organisasi" name="id_organisasi" class="form-control" multiple="multiple" style="width: 100%"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Provinsi</label>
                <div class="col-10">
                    <select id="id_provinsi_indonesia" class="form-control" multiple>
                        @foreach(collect(DB::table('provinsi_indonesia')->select('id_provinsi_indonesia',
                        'nama_provinsi_indonesia')->get()) as $row)
                        <option value="{{$row->id_provinsi_indonesia}}">{{$row->nama_provinsi_indonesia}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Berdasarkan Surat Ditujukan</label>
                <div class="col-10">
                    <select id="id_surat_ditujukan" name="id_surat_ditujukan" class="form-control" multiple="multiple"></select>
                </div>
            </div>


            <hr>
            <div class="text-right">
                <a href="{{url('master-organisasi/' . Session::get('id_users'))}}" class="btn btn-secondary font-italic font-weight-bold">Kembali</a>
                <button type="button" id="btn-reset" class="btn btn-secondary font-italic font-weight-bold">Refresh</button>
                <button type="button" id="btn-filter" class="btn btn-secondary font-italic font-weight-bold">Filter</button>
            </div>
        </form>
    </div>


    <div class="card card-body">
        <form class="form_default" method="POST" action="{{url('label-surat/buat-label')}}" target="_blank">
            @csrf

            <div class="row">
                <div class="checkbox-inline col-6">
                    <label class="checkbox checkbox-lg checkbox-primary">
                        <input type="checkbox" class="checkAll font-weight-bold" name="checkAll" id="checkAll" />
                        <span></span><b class="text-primary">Pilih Semua</b>
                    </label>
                </div>
            </div>

            <hr>

            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead class="">
                        <tr>
                            <th class="font-weight-bold">#</th>
                            <th class="font-weight-bold">Organisasi</th>
                            <th class="font-weight-bold">Instansi</th>
                            <th class="font-weight-bold">Provinsi</th>
                            <th class="font-weight-bold">Surat Ditujukan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <br>
            <hr>
            <br>
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-secondary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="1">Cetak Ukuran 60 x 40 mm Tanpa Nomor Telepon</button>
                    <button class="btn btn-secondary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="3">Cetak Ukuran 70 x 40 mm Tanpa Nomor Telepon</button>
                    <button class="btn btn-secondary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="5">Cetak Ukuran 70 x 50 mm Tanpa Nomor Telepon</button>
                    <button class="btn btn-secondary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="7">Cetak Ukuran 100 x 50 mm Tanpa Nomor Telepon</button>
                </div>
                <div class="col-6 text-right">
                    <button class="btn btn-light-primary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="2">Cetak Ukuran 60 x 40 mm Dengan Nomor Telepon</button>
                    <button class="btn btn-light-primary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="4">Cetak Ukuran 70 x 40 mm Dengan Nomor Telepon</button>
                    <button class="btn btn-light-primary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="6">Cetak Ukuran 70 x 50 mm Dengan Nomor Telepon</button>
                    <button class="btn btn-light-primary btn-block font-weight-bold tombolSubmit" name="is_submit" type="submit" value="8">Cetak Ukuran 100 x 50 mm Dengan Nomor Telepon</button>
                </div>
            </div>
            <button class="btn btn-light-success btn-block font-weight-bold tombolSubmit mt-3" name="is_submit" type="submit" value="get_email"><i class="fa fa-envelope"></i> Get Email</button>
        </form>
    </div>
</div>

@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    $('#id_provinsi_indonesia').select2({
        placeholder: "Choose tags..."
    });
    // $('select').selectpicker({search : true});
    $(document).ready(function() {
        table = $('#table').DataTable({
            "scrollY": "600px",
            "scrollCollapse": true,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "Semua data"]
            ],
            "pageLength": 10,
            "order": [],
            "language": {
                "processing": '<i class="fa fa-spin fa-spinner" style="font-size:50px; color:lightblue;"></i>',
            },
            "order": [],


            "ajax": {
                "url": "{{url('label-surat')}}",
                "data": function(d) {
                    d.id_agency_category = $('select[name="id_agency_category"]').val(),
                        d.id_agency = $('select[name="id_agency"]').val(),
                        d.id_organisasi = $('select[name="id_organisasi"]').val(),
                        d.id_surat_ditujukan = $('select[name="id_surat_ditujukan"]').val(),
                        d.id_provinsi_indonesia = $('#id_provinsi_indonesia').val(),
                        d.search = $('#table_filter :input[type="search"]').val()
                }
            },

            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'select_organisasi',
                name: 'select_organisasi'
            }, {
                data: 'nama_turunan_organisasi',
                name: 'nama_turunan_organisasi'
            }, {
                data: 'nama_provinsi_indonesia',
                name: 'nama_provinsi_indonesia'
            }, {
                data: 'new_surat_ditujukan',
                name: 'new_surat_ditujukan'
            }],
        });


        $('#btn-filter').click(function() {
            table.draw();
        });

        $('#btn-reset').click(function() {
            $('select[name="id_agency_category"]').val(null).trigger('change');
            $('select[name="id_agency"]').val(null).trigger('change');
            $('select[name="id_organisasi"]').val(null).trigger('change');
            $('#id_provinsi_indonesia').val(null).trigger('change');
            $('select[name="id_surat_ditujukan"]').val(null).trigger('change');
            $('#form-filter')[0].reset();
            table.ajax.reload();
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('.tombolSubmit').click(function() {
            checked = $("input[type=checkbox]:checked").length;

            if (!checked) {
                alert("Anda harus mencentang setidaknya satu organisasi.");
                return false;
            }
        });
    });


    $(document).ready(function() {
        $("#checkAll").click(function() {
            $(".child").prop("checked", this.checked);
        });
    });
</script>


<!-- <script>
$('.form_default').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    // build the ajax call

    Swal.fire({
        title: 'Informasi',
        html: "Apakah anda yakin ingin membuat surat proposal ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                beforeSend: function() {
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
                    $('.tombolSubmit').removeAttr('disabled');
                    $('.tombolSubmit').html('<i class="fa fa-print"></i> Generate Proposal');
                },
                success: function(response) {
                    // handle success response
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.href =
                            "#"
                    }, 1000);
                    // table.ajax.reload();
                    // console.log(response.id_proposal_template);
                },
                error: function(response) {
                    alert('Error generate data!');
                },
                contentType: false,
                processData: false
            });
        }
    });
})
</script> -->

<script>
    $('#id_organisasi').select2({
        placeholder: "Choose tags...",
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

    $('#id_agency_category').select2({
        placeholder: "Choose tags...",
        minimumInputLength: 2,
        ajax: {
            url: "{{url('select-filter/ajax_agency_category')}}",
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

    $('#id_agency').select2({
        placeholder: "Choose tags...",
        minimumInputLength: 2,
        ajax: {
            url: "{{url('select-filter/ajax_agency')}}",
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
        placeholder: "Choose tags...",
        minimumInputLength: 2,
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
@endsection