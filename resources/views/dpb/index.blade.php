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
                <div class="col-6">
                </div>
            </div>

            <hr>
            <br>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <!-- <th>Jenis</th>
                            <th>Bidang / Sub Bidang Pekerjaan</th>
                            <th>Pemberi Kerja</th>
                            <th>Nama Pekerjaan</th>
                            <th>Nilai Kontrak (Rp)</th>
                            <th>Termin Pembayaran</th>
                            <th>Durasi Kontrak Pekerjaan</th>
                            <th>Tanggal Terima Kontrak</th>
                            <th>Tanggal Terima Surat Referensi</th>
                            <th>Tanggal Terima BAST</th>
                            <th>PIC</th>
                            <th>Perubahan Terakhir</th>
                            <th>Keterangan DPB</th> -->
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
            "url": "{{url('dpb/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
            "data": function(d) {
                d.search = $('input[type="search"]').val()
            }
        },


        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            }, {
                data: 'kode',
                name: 'kode'
            }
            // , {
            //     data: 'jenis_pekerjaan_dpb',
            //     name: 'jenis_pekerjaan_dpb'
            // }, {
            //     data: 'nama_bidang_pekerjaan',
            //     name: 'nama_bidang_pekerjaan'
            // }, {
            //     data: 'pemberi_kerja',
            //     name: 'pemberi_kerja'
            // }, {
            //     data: 'nama_pekerjaan_dpb',
            //     name: 'nama_pekerjaan_dpb'
            // }, {
            //     data: 'nilai_kontrak_dpb',
            //     name: 'nilai_kontrak_dpb'
            // }, {
            //     data: 'jumlah_termin_pembayaran',
            //     name: 'jumlah_termin_pembayaran'
            // }, {
            //     data: 'durasi_kontrak_pekerjaan',
            //     name: 'durasi_kontrak_pekerjaan'
            // }, {
            //     data: 'tgl_terima_kontrak',
            //     name: 'tgl_terima_kontrak'
            // }, {
            //     data: 'tgl_terima_surat_referensi',
            //     name: 'tgl_terima_surat_referensi'
            // }, {
            //     data: 'tgl_terima_bast',
            //     name: 'tgl_terima_bast'
            // }, {
            //     data: 'pic_dpb',
            //     name: 'pic_dpb'
            // }, {
            //     data: 'updated',
            //     name: 'updated'
            // }, {
            //     data: 'keterangan_dpb',
            //     name: 'keterangan_dpb'
            // }

        ],
    });
});
</script>
@endsection