@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="container-fluid">

    <div class="card card-custom">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h4 class="text-primary font-weight-bolder">
                        {{strtoupper('Formulir Informasi Pekerjaan (FIP) Admin Proyek')}}</h4>
                </div>
                <div class="col-6">
                    <div class="text-right">
                    <a data-toggle="modal" data-target="#export" class="btn btn-light-success font-weight-bold mr-2"><i class="fa fa-file-excel"></i> Export Excel</a>
                        <a type="button" class="btn btn-light-info font-weight-bold" data-toggle="collapse"
                            href="#filter"><i class="fa fa-filter"></i> Filter FIP</a>
                    </div>
                </div>
            </div>

            <hr>

            <div class="collapse mb-5" id="filter">
                <div class="card card-body">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label text-info font-weight-bold">Tahun</label>
                            <select id='tahun' class="form-control">
                                <option value="">Please Select</option>
                                @for ($x = date('Y'); $x >= 2004; $x--)
                                <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <br>

            <div class="table-responsive">
                <table class="table table-hover table-stripe" id="table">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th width="8%">Kode</th>
                            <th>Jenis</th>
                            <th>Nama & Sub Bidang Pekerjaan</th>
                            <th>Pemberi Kerja</th>
                            <th>Durasi Pekerjaan</th>
                            <th>PIC Marketing</th>
                            <th>PIC Adpro</th>
                            <th>PIC Konsultan</th>
                            <th>Tanggal BAST</th>
                            <th>Perubahan Terakhir</th>
                            <th>Acc Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- ======================================= MODAL TANGGAL BAST ========================================== -->
<div class="modal fade" id="modal_tunjuk_pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="bodyModalTunjukPIC">
            <i class='fa fa-spin fa-spinner' style='font-size:50px;'></i>
        </div>
    </div>
</div>



<!-- MODAL EXPORT EXCEL -->
<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light-success">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Periode Tahun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="GET" action="{{url('fip-adpro/export')}}" target="_blank">
                    <div class="form-group row mb-5">
                        <label class="col-sm-3 col-form-label font-weight-bold">Mulai <b class="text-danger">*</b></label>
                        <div class='col-sm-9'>

                            <select class="form-control" name="mulai" placeholder="Pilih rentang tahun.." required>
                                <option value="">Please Select</option>
                                @for ($x = date('Y'); $x >= 2004; $x--)
                                <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        <label class="col-sm-3 col-form-label font-weight-bold">Sampai <b class="text-danger">*</b></label>
                        <div class='col-sm-9'>

                            <select class="form-control" name="sampai" placeholder="Pilih rentang tahun.." required>
                                <option value="">Please Select</option>
                                @for ($x = date('Y'); $x >= 2004; $x--)
                                <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <br>
                    <hr>

                    <div class="text-right">
                        <button class="btn btn-secondary btn-sm font-weight-bold tombolCancel" data-dismiss="modal" aria-label="Close">Batal</button>
                        <button class="btn btn-primary btn-sm font-weight-bold tombolSubmit" type="submit">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$('#lokasi').select2({
    placeholder: "Please Select",
    width: '100%'
});
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
            "url": "{{url('fip-adpro/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
            "data": function(d) {
                d.tahun = $('#tahun').val(),
                    d.search = $('input[type="search"]').val()
            }
        },

        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        }, {
            data: 'kode_fip',
            name: 'kode_fip'
        }, {
            data: 'jenis_pekerjaan',
            name: 'jenis_pekerjaan'
        }, {
            data: 'nama_pekerjaan_fip',
            name: 'nama_pekerjaan_fip'
        }, {
            data: 'pemberi_kerja',
            name: 'pemberi_kerja'
        }, {
            data: 'durasi_kerja',
            name: 'durasi_kerja'
        }, {
            data: 'pic_marketing',
            name: 'pic_marketing'
        }, {
            data: 'pic_adpro',
            name: 'pic_adpro'
        }, {
            data: 'pic_konsultan',
            name: 'pic_konsultan'
        }, {
            data: 'tanggal_bast',
            name: 'tanggal_bast'
        }, {
            data: 'updated',
            name: 'updated'
        }, {
            data: 'acc_oleh',
            name: 'acc_oleh'
        }],
    });

    $('#tahun').change(function() {
        table.draw();
    });
});
</script>



<script>
function showTunjukPIC(id) {
    $('#bodyModalTunjukPIC').html(
        "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size:25px;'></i></div>");

    $.ajax({
        type: "get",
        url: "{{url('fip-adpro/modal-tunjuk-pic')}}/" + id,
        dataType: "text",
        success: function(response) {
            $('#bodyModalTunjukPIC').empty();
            $('#bodyModalTunjukPIC').append(response);
        }
    });
}
</script>
@endsection