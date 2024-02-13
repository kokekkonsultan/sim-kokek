@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap" rel="stylesheet">

<style>
    .select2-container .select2-selection--single {
        height: 35px;
        font-size: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}</h2>
    </div>
    <div class="card card-custom">
        <div class="card-body">

            <a class="btn btn-light-dark font-weight-bolder" href="{{url('daftar-penawaran/' . Session::get('id_users'))}}"><i class="fa fa-arrow-left"></i> Kembali ke Daftar Penawaran</a>

            <br>
            <br>


            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" width="100%">

                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Tahap</th>
                            <th class="text-center">Mulai</th>
                            <th class="text-center">Sampai</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach(DB::select("SELECT * FROM tahap_lelang JOIN data_tahapan_lelang ON tahap_lelang.id_data_tahapan_lelang = data_tahapan_lelang.id_data_tahapan_lelang WHERE id_dil = $dil->id_dil") as $row)
                        <tr>
                            <td class="text-center">{{$no++}}</td>
                            <td>{{$row->nama_tahapan_lelang}}</td>
                            <td class="text-center">{{$row->waktu_mulai_tahap_lelang}}</td>
                            <td class="text-center">{{$row->waktu_sampai_tahap_lelang}}</td>
                            <td>
                                <a class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#ubah_{{$row->id_tahap_lelang}}"><i class="fa fa-edit"></i> Ubah</a>

                                <div class="modal fade" id="ubah_{{$row->id_tahap_lelang}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-primary" id="exampleModalLabel">{{$row->nama_tahapan_lelang}}</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form_default" method="POST" action="{{url('daftar-penawaran/ubah-jadwal-lelang/' . Request::segment(3))}}">
                                                    @csrf

                                                    <input name="id_tahap_lelang" value="{{$row->id_tahap_lelang}}" hidden>

                                                    <div class="form-group">
                                                        <label class="col-form-label font-weight-bolder">Waktu Mulai <b class="text-danger">*</b></label>
                                                        <input class="form-control" type="datetime-local" name="waktu_mulai_tahap_lelang" value="{{$row->waktu_mulai_tahap_lelang}}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-form-label font-weight-bolder">Waktu Sampai <b class="text-danger">*</b></label>
                                                        <input class="form-control" type="datetime-local" name="waktu_sampai_tahap_lelang" value="{{$row->waktu_sampai_tahap_lelang}}" required>
                                                    </div>


                                                    <div class="text-right">
                                                        <button class="btn btn-secondary font-weight-bold" data-dismiss="modal" aria-label="Close">Batal</button>
                                                        <button class="btn btn-primary font-weight-bold" type="submit">Simpan</button>
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


@endsection