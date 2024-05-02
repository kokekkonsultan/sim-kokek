@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">
            {!! strtoupper($title)  . '<br>' .  strtoupper($current->nama_organisasi_utama) !!}
        </h2>
    </div>

    <div class="card card-custom">
        <div class="card-body">

            <div class="text-right mb-5">
                <!-- <a type="button" class="btn btn-secondary font-weight-bold mr-2" href="{{url('master-organisasi/' . Session::get('id_users'))}}"><i class="fa fa-arrow-left"></i> Kembali</a> -->
                
                <a type="button" class="btn btn-light-info font-weight-bold" data-toggle="collapse" href="#filter"><i class="fa fa-filter"></i> Filter Data</a>
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

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tgl_mulai">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Tanggal Sampai</label>
                                <input type="date" class="form-control" id="tgl_sampai">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Aktivitas</th>
                            <th>PIC</th>
                            <th>Dibuat</th>
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
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
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
            "url": "{{url('master-organisasi/log-aktivitas/' . Request::segment(3))}}", // memanggil route yang menampilkan data json
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
        }, {
            data: 'aktivitas',
            name: 'aktivitas'
        }, {
            data: 'user_name',
            name: 'user_name'
        }, {
            data: 'created_at',
            name: 'created_at'
        }],
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
@endsection