@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap" rel="stylesheet" />
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

            <div class="row">
                <div class="col-6">
                    <h4 class="text-primary font-weight-bolder">{{strtoupper($title)}}</h4>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Proposal</a>
                </div>
            </div>
            <hr>
            <br>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table">
                    <thead class="">
                        <tr>
                            <th>No.</th>
                            <th>Jenis Proposal</th>
                            <th>Nama Proposal</th>
                            <th>Produk</th>
                            <th>Dibuat Pada</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- modal add -->
<div class="modal fade" id="add" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form class="form_default" method="POST" action="{{url('master-proposal/add')}}">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Jenis Proposal <b class="text-danger">*</b></label>
                        <select name="id_jenis_proposal" id="id_jenis_proposal" class="form-control form-select" required>
                            <option value="">Please Select</option>
                            @foreach(DB::table('jenis_proposal')->where('is_default', null)->get() as $row)
                            <option value="{{$row->id}}">{{$row->nama_jenis_proposal}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Produk <b class="text-danger">*</b></label>
                        <select name="id_bidang_pekerjaan" id="id_bidang_pekerjaan" class="form-control form-select" required>
                            <option value="">Please Select</option>
                            @foreach(DB::table('bidang_pekerjaan')->get() as $row)
                            <option value="{{$row->id_bidang_pekerjaan}}">{{$row->nama_bidang_pekerjaan}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Nama Proposal <b class="text-danger">*</b></label>
                        <input name="nama_master_proposal" placeholder="Nama Proposal" class="form-control" type="text" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary font-weight-bold tombolCancel" data-dismiss="modal" aria-label="Close">Batal</button>
                    <button class="btn btn-primary font-weight-bold tombolSubmit" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Edit -->
@foreach(DB::table('master_proposal')->get() as $value)
<div class="modal fade" id="edit{{$value->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form class="form_default" method="POST" action="{{url('master-proposal/edit')}}">
                @csrf
                <div class="modal-body">

                    <input name="id" value="{{$value->id}}" hidden>

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Jenis Proposal <b class="text-danger">*</b></label>
                        <select name="id_jenis_proposal" id="id_jenis_proposal" class="form-control form-select" required>
                            <option value="">Please Select</option>
                            @foreach(DB::table('jenis_proposal')->where('is_default', null)->get() as $row)
                            <option value="{{$row->id}}" {{$row->id == $value->id_jenis_proposal ? 'selected' : ''}}>{{$row->nama_jenis_proposal}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Produk <b class="text-danger">*</b></label>
                        <select name="id_bidang_pekerjaan" id="id_bidang_pekerjaan" class="form-control form-select" required>
                            <option value="">Please Select</option>
                            @foreach(DB::table('bidang_pekerjaan')->get() as $row)
                            <option value="{{$row->id_bidang_pekerjaan}}" {{$row->id_bidang_pekerjaan == $value->id_bidang_pekerjaan ? 'selected' : ''}}>{{$row->nama_bidang_pekerjaan}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Nama Proposal <b class="text-danger">*</b></label>
                        <input name="nama_master_proposal" placeholder="Nama Proposal" value="{{$value->nama_master_proposal}}" class="form-control" type="text" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary font-weight-bold tombolCancel" data-dismiss="modal" aria-label="Close">Batal</button>
                    <button class="btn btn-primary font-weight-bold tombolSubmit" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
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
                "url": "{{url('master-proposal/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
                "data": function(d) {}
            },

            //data pagu diambil dari sini
            // "fnCreatedRow": function(row, data, index) {
            //     $('td', row).eq(4).html(new Date(data.created_at).toLocaleDateString());
            // },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'nama_jenis_proposal',
                    name: 'nama_jenis_proposal'
                }, {
                    data: 'nama_master_proposal',
                    name: 'nama_master_proposal'
                }, {
                    data: 'nama_bidang_pekerjaan',
                    name: 'nama_bidang_pekerjaan'
                }, {
                    data: 'date',
                    name: 'date'
                }, {
                    data: 'btn',
                    name: 'btn'
                }

            ],
        });
    });
</script>


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
                // handle success response
                toastr["success"]('Data berhasil disimpan');
                table.ajax.reload();
                // console.log(response.data);
            },
            error: function(response) {
                // handle error response
                alert('Error submit data!');
                // console.log(response.data);
            },
            contentType: false,
            processData: false
        });
    })
</script>


<script>
    function delete_data(id) {
        if (confirm('Anda akan menghapus data ini ?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('master-proposal/delete-data')}}/" + id,
                dataType: "JSON",
                success: function(data) {
                    if (data.status === true) {
                        Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                        table.ajax.reload();
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