@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

<style>
    .outer-box {
        font-family: arial;
        font-size: 24px;
        width: 500px;
        height: 330px;
        outline: dashed 1px #d3d3d3;
        background-color: #E3B07D;
        padding: 35px;
        text-align: center;
    }

    .box-edge {
        font-family: arial;
        font-size: 14px;
        width: 406px;
        height: 196px;
        padding: 8px;
        background-color: #ffffff;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .box {
        font-family: arial;
        font-size: 14px;
        width: 390px;
        height: 180px;
        outline: solid 1px black;
        padding: 15px 25px 25px 25px;
        background-color: #ffffff;
    }

    .box-no-border {
        font-family: arial;
        font-size: 14px;
        width: 390px;
        height: 180px;
        outline: solid 0px black;
        padding: 15px 25px 25px 25px;
        background-color: #ffffff;
    }

    p {
        /* Center horizontally*/
        text-align: left;
        font-weight: bold;
    }
</style>

@endsection

@section('content')
<div class="container-fluid">

    <div class="card card-custom">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h4 class="text-primary font-weight-bolder">{{strtoupper($title)}}</h4>
                </div>
                <div class="col-6 text-right">

                    <div class="dropdown dropdown-inline mr-2">
                        <button type="button" class="btn btn-secondary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Cetak</button>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <ul class="navi flex-column navi-hover py-2">
                                <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                    Choose an option:</li>
                                <li class="navi-item">
                                    <a href="{{url('label-surat')}}" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-arrow-right"></i>
                                        </span>
                                        <span class="navi-text">Cetak Label Surat & Get Email Organisasi</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="{{url('label-surat-sirup')}}" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-arrow-right"></i>
                                        </span>
                                        <span class="navi-text">Cetak Label Surat Sirup</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="{{url('master-organisasi/form-label-pengirim')}}" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-arrow-right"></i>
                                        </span>
                                        <span class="navi-text">Cetak Pengirim</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a type="button" class="btn btn-light-info font-weight-bold mr-2" data-toggle="collapse" href="#filter"><i class="fa fa-filter"></i> Filter Data</a>

                    <a href="{{url('master-organisasi/form-add')}}" class="btn btn-primary font-weight-bold"><i class="fa fa-plus"></i> Tambah Organisasi</a>
                </div>
            </div>

            <hr>
            <br>



            <div class="collapse card card-body shadow mb-10" id="filter">
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
                                <option value="{{$row->id_provinsi_indonesia}}">{{$row->nama_provinsi_indonesia}}
                                </option>
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

                    <div class="text-right">
                        <button type="button" id="btn-reset" class="btn btn-secondary font-italic font-weight-bold">Refresh</button>
                        <button type="button" id="btn-filter" class="btn btn-secondary font-italic font-weight-bold">Filter</button>
                    </div>
                </form>
            </div>

            


            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead class="">
                        <tr>
                            <th width="4%">No.</th>
                            <th width="5%"></th>
                            <th>Nama Organisasi</th>
                            <th>Nama Instansi</th>
                            <th>Email</th>
                            <!-- <th>Surat Ditujukan</th> -->
                            <th></th>
                            <th width="9%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js">
</script>
<script>
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
                "url": "{{url('master-organisasi/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
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
                    data: 'btn_kop',
                    name: 'btn_kop'
                }, {
                    data: 'nama_organisasi_utama',
                    name: 'nama_organisasi_utama'
                }, {
                    data: 'nama_turunan_organisasi',
                    name: 'nama_turunan_organisasi'
                }, {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'btn_aktivitas',
                    name: 'btn_aktivitas'
                }, {
                    data: 'btn_action',
                    name: 'btn_action'
                }
            ],
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
    function delete_data(id1, id2) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: "Anda akan menghapus data Organisasi <b>" + id2 + "</b> ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya Hapus',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{url('master-organisasi/delete-organisasi')}}/" + id1,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status === true) {
                            Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                            table.ajax.reload();
                        }

                        if (data.status === false) {
                            Swal.fire('Error',
                                'Tidak dapat menghapus, data Daftar Penawaran digunakan di Daftar Proyek Berjalan DPB',
                                'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });


            }
        })
    }
</script>



<script>
    $('#id_provinsi_indonesia').select2({
        placeholder: "Choose tags...",
        width: '100%'
    });


    $('#id_organisasi').select2({
        placeholder: "Choose tags...",
        minimumInputLength: 2,
        width: '100%',
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
        width: '100%',
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
        width: '100%',
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
        width: '100%',
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