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
                    <h4 class="text-primary font-weight-bolder">{{strtoupper($title)}}</h4>
                </div>
                <div class="col-6 text-right">
                    <a type="button" class="btn btn-secondary font-weight-bold mr-2" data-toggle="collapse" href="#filter"><i class="fa fa-filter"></i> Filter Data</a>
                    <a class="btn btn-success font-weight-bold"><i class="fa fa-print"></i> Print Weekly</a>
                </div>
            </div>

            <div class="collapse mb-5 mt-5" id="filter">
                <div class="card card-body shadow">
                    <div class="row">
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bold">PIC</label>
                                <select id='id_user' class="form-control">
                                    <option value="">Please Select</option>
                                    @foreach(DB::select("SELECT *
                                    FROM pic_wilayah_marketing
                                    JOIN users ON pic_wilayah_marketing.id_user = users.id
                                    GROUP BY id_user") as $row)
                                    <option value="{{$row->id_user}}">{{$row->first_name . ' ' . $row->last_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->

                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tgl_mulai">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Tanggal Sampai</label>
                                <input type="date" class="form-control" id="tgl_sampai">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <br>

            <div class="table-responsive">
                <table class="table table-hover" id="table">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Aktivitas</th>
                            <th>Organisasi</th>
                            <th>Contact Person</th>
                            <th>PIC</th>
                            <th>Tindak Lanjut</th>
                            <th>Tanggal Tindak Lanjut</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- ======================================= Tindak Lanjut ========================================== -->
<div class="modal fade" id="modal_tindak_lanjut" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="font-weight-bold">Tindak Lanjut</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="bodyModalTindakLanjut">
                <div align="center" id="loading_registration">
                    <i class='fa fa-spin fa-spinner' style='font-size:50px;'></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$('#id_contact_person').select2({placeholder: "Please Select", width:'94%'});
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
            "url": "{{url('weekly-planning/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
            "data": function(d) {
                d.search = $('input[type="search"]').val(),
                    d.id_user = $('#id_user').val(),
                    d.tgl_mulai = $('#tgl_mulai').val(),
                    d.tgl_sampai = $('#tgl_sampai').val()
            }
        },

        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        },{
            data: 'dibuat',
            name: 'dibuat'
        }, {
            data: 'aktivitas',
            name: 'aktivitas'
        }, {
            data: 'organisasi',
            name: 'organisasi'
        }, { 
            data: 'contact_person_name',
            name: 'contact_person_name'
        
        }, {
            data: 'nama_pic',
            name: 'nama_pic'
        }, {
            data: 'tl',
            name: 'tl'
        }, {
            data: 'date_follow_up',
            name: 'date_follow_up'
        }]
    });

    $('#id_user').change(function() {
        table.draw();
    });
    $('#tgl_mulai').change(function() {
        table.draw();
    });
    $('#tgl_sampai').change(function() {
        table.draw();
    });
});
</script>


<script>
    function showTindakLanjut(id) {
        $('#bodyModalTindakLanjut').html(
            "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size:25px;'></i></div>");

        $.ajax({
            type: "get",
            url: "{{url('daily-report/show_modal_tindak_lanjut')}}/" + id,
            dataType: "text",
            success: function(response) {
                $('#bodyModalTindakLanjut').empty();
                $('#bodyModalTindakLanjut').append(response);
            }
        });
    }
</script>

@endsection