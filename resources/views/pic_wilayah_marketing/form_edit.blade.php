@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">

    <div class="card card-custom">
        <div class="card-body">

            <div class="row">
                <div class="col-6">
                    <h4 class="text-primary font-weight-bolder">{{strtoupper($title)}}</h4>
                </div>
                
            </div>

            <hr>
            <br>

            <form class="form_default" method="POST" action="{{url('pic-wilayah-marketing/proses-edit/' . Request::Segment(3))}}">
                @csrf

                <div class="form-group row mb-5">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama PIC <b class="text-danger">*</b></label>
                    <div class="col-sm-9 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                        </div>
                        <select class="form-control" name="pic" required>
                            <option value="">Please Select</option>
                            @foreach(DB::select("SELECT users.id AS users_id, CONCAT(users.first_name, ' ',
                            users.last_name) AS users_name
                            FROM users
                            JOIN users_groups ON users_groups.user_id = users.id
                            JOIN groups ON groups.id = users_groups.group_id
                            WHERE groups.name = 'marketing' AND users.active = 1") as $row)
                            <option value="{{$row->users_id}}" {{Request::Segment(3) == $row->users_id ? 'selected' : ''}}>{{$row->users_name}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-1">
                        <button type="submit" class="btn btn-light-primary font-weight-bold">Simpan</button>
                    </div>
                </div>
            </form>


            <br>
            <br>

            <a class="btn btn-primary btn-sm font-weight-bold mb-5" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Cakupan Wilayah PIC</a>

            <table class="table table-hover table-bordered">
                <thead class="bg-secondary">
                    <tr>
                        <th width="4%">No</th>
                        <th>Cakupan Wilayah</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach(DB::table('pic_wilayah_marketing')->where('id_user', Request::Segment(3))->get() as $value)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$value->nama_wilayah}}</td>
                        <td>
                            <a class="btn btn-light-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#edit{{$value->id}}"><i class="fa fa-edit"></i> Edit</a>
                            <a class="btn btn-light-danger btn-sm font-weight-bold" href="javascript:void(0)" onclick="delete_data('{{$value->id}}')"><i class="fa fa-trash"></i> Hapus</a>

                            <div class="modal fade" id="edit{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary">
                                            <span class="modal-title" id="exampleModalLabel">Edit Cakupan Wilayah
                                                PIC</span>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                                        </div>
                                        <div class="modal-body">

                                            <form class="form_default" method="POST" action="{{url('pic-wilayah-marketing/edit-wilayah/' . Request::Segment(3))}}">
                                                @csrf

                                                <input name="id" value="{{$value->id}}" hidden>

                                                <div class="form-group">
                                                    <label class="col-form-label font-weight-bold">Wilayah <b class="text-danger">*</b></label>
                                                    <textarea class="form-control" name="nama_wilayah" required>{{$value->nama_wilayah}}</textarea>
                                                </div>

                                                <br>
                                                <hr>
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-left mt-5">
                <a class="btn btn-secondary font-weight-bold" href="{{url('pic-wilayah-marketing/' . Session::get('id_users'))}}"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>

    </div>
</div>



<!-- MODAL ADD -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <span class="modal-title" id="exampleModalLabel">Tambah Cakupan Wilayah PIC</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST" action="{{url('pic-wilayah-marketing/add-wilayah/' . Request::Segment(3))}}">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Wilayah <b class="text-danger">*</b></label>
                        <textarea class="form-control" name="nama_wilayah" required></textarea>
                    </div>

                    <br>
                    <hr>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
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

<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    function delete_data(id) {
        if (confirm('Anda akan menghapus data ini ?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('pic-wilayah-marketing/delete-wilayah')}}/" + id,
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