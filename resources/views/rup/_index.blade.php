@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<style type="text/css">
[pointer-events="bounding-box"] {
    display: none
}
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap" rel="stylesheet">

<style>
    table{
        font-family: 'Inter', sans-serif;

    }
    table > thead{
        background-color: #f3f3f3;
    }
</style>

@endsection

@section('content')
<div class="container-fluid">

    <div class="card card-custom">
        
    <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Rencana Umum Pengadaan
                </h3>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-toggle="modal" data-target="#grafikNilaiPekerjaan">
                    Grafik Nilai Nett Omzet
                 </button>
                 &nbsp;
                 <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-toggle="modal" data-target="#grafikJumlahPekerjaan">
                    Grafik Jumlah Pekerjaan
                 </button>
                 &nbsp;
                <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#filterModal">
                    Filter
                </button>
            </div>

        </div>

        <div class="card-body">
            <!-- <div class="text-end mb-3">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add">
                    <i class="fas fa-plus"></i> Tambah Profil Responden
                </button>
            </div> -->

            <div class="table-responsive">
                <table id="example" class="table table-hover display compact" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Paket</th>
                            <th>Pagu (Rp)</th>
                            <th>Jenis Pengadaan</th>
                            <th>Produk Dakam Negeri</th>
                            <th>Usaha Kecil/ Koperasi</th>
                            <th>Metode</th>
                            <th>Pemilihan</th>
                            <th>K/L/PD</th>
                            <th>Satuan Kerja</th>
                            <th>Lokasi</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                    <tbody>

                    @php
                    $no = 1;
                    @endphp
                    @foreach($data_rup as $value)

                    <tr>
                        <td>{{$no++}}</td>
                        <td>{!! '<span class="text-danger">' . $value->nama_pekerjaan . '</span><br>' . $value->nama_bidang_pekerjaan !!}</td>
                        <td>{{$value->pagu}}</td>
                        <td>{{$value->nama_jenis_pengadaan}}</td>
                        <td>{{$value->nama_jenis_produk}}</td>
                        <td>{{$value->nama_jenis_usaha}}</td>
                        <td>{{$value->nama_metode_pengadaan}}</td>
                        <td>{{$value->waktu_pemilihan_penyedia}}</td>
                        <td>{{$value->klpd}}</td>
                        <td>{{$value->satuan_kerja}}</td>
                        <td>{{$value->lokasi_pekerjaan}}</td>
                        <td>{{$value->id_sis_rup}}</td>
                    </tr>

                    @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" style="text-align:right">Total:</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    var example;

    $(document).ready(function() {
        example = $("#example").DataTable({
            "bFilter": true,
            "bPaginate": false,
            "responsive": false,
            "processing": true,
            "serverSide": false,
            "ordering": false,
            "searching": true,
            "paging": false,
            "scrollY": "600px",
            "scrollCollapse": true,
            "scrollX": true,
            // "dom": 'Blfrtip',
            // "buttons": [{
            //     extend: 'collection',
            //     text: 'Export Excel',
            //     buttons: [
            //     'excel'
            //     ]
            // }],

        });
    });
    </script>

@endsection