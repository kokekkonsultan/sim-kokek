@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap" rel="stylesheet" />
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
                    <div class="text-right">
                     <a type="button" class="btn btn-success font-weight-bold" href="{{url('prospek/export/excel/' . Request::segment(2))}}"><i class="fa fa-download"></i> Export Excel</a>
                        <a type="button" class="btn btn-dark font-weight-bold" data-toggle="collapse" href="#filter"><i class="fa fa-filter"></i> Filter Data</a>
                        <!-- <a type="button" class="btn btn-primary btn-sm font-weight-bold me-2" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah RUP</a>
                        <a type="button" class="btn btn-secondary btn-sm font-weight-bold me-2">Export Excel</a>
                        <button class="btn btn-danger" id="btn-reset">Reset</button> -->
                    </div>
                </div>
            </div>

            <hr>



            <div class="collapse mb-5" id="filter">
                <div class="card card-body shadow">
                    <div class="row">
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bold">PIC</label>
                                <select id='pic' class="form-control">
                                    <option value="">Please Select</option>
                                    @foreach(DB::select("SELECT DISTINCT(pic) AS pic FROM
                                    view_rencana_umum_pengadaan
                                    WHERE pic != ''") as $row)
                                    <option value="{{$row->pic}}">{{$row->pic}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->

                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bold">Metode</label>
                                <select id='metode' class="form-control">
                                    <option value="">Please Select</option>
                                    @foreach(DB::select("SELECT DISTINCT(nama_metode_pengadaan) FROM view_rencana_umum_pengadaan
                                    UNION
                                    SELECT nama_metode_pengadaan FROM metode_pengadaan") as $row)
                                    <option value="{{$row->nama_metode_pengadaan}}">{{$row->nama_metode_pengadaan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bold">Bulan</label>
                                <select id='bulan' class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="Jan">Januari</option>
                                    <option value="Feb">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="Apr">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Jun">Juni</option>
                                    <option value="Jul">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="Septe">September</option>
                                    <option value="Okt">Oktober</option>
                                    <option value="Nov">November</option>
                                    <option value="Des">Desember</option>
                                </select>
                            </div>
                        </div>
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
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bold">Pagu</label>
                                <select id='pagu' class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="ASC">Ascending (Kecil ke Besar)</option>
                                    <option value="DESC">Descending (Besar ke Kecil)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bold">Lokasi</label>
                                <select id='lokasi' class="form-control">
                                    <option value="">Please Select</option>
                                    @php
                                    $year = date('Y');
                                    @endphp
                                    @foreach(DB::select("SELECT DISTINCT(lokasi_pekerjaan) AS lokasi_pekerjaan FROM
                                    view_rencana_umum_pengadaan WHERE lokasi_pekerjaan != '' && tahun_anggaran = $year") as $row)
                                    <option value="{{$row->lokasi_pekerjaan}}">{{$row->lokasi_pekerjaan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bold">Status Surat</label>
                                <select id='status_surat' class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="0">Belum di Cetak</option>
                                    <option value="1">Sudah di Cetak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table" style="font-family: 'Inter', sans-serif;">
                    <thead class="">
                        <tr>
                            <th class="font-weight-bolder">#</th>
                            <th class="font-weight-bolder">Paket</th>
                            <th class="font-weight-bolder">Pagu (Rp)</th>
                            <th class="font-weight-bolder">Jenis Pengadaan</th>
                            <th class="font-weight-bolder">Produk Dakam Negeri</th>
                            <th class="font-weight-bolder">Usaha Kecil/ Koperasi</th>
                            <th class="font-weight-bolder">Metode</th>
                            <th class="font-weight-bolder">Pemilihan</th>
                            <th class="font-weight-bolder">K/L/PD</th>
                            <th class="font-weight-bolder">Satuan Kerja</th>
                            <th class="font-weight-bolder">Lokasi</th>
                            <th class="font-weight-bolder">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot align="right">
                        <tr>
                            <th></th>
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
                "url": "{{url('prospek/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
                "data": function(d) {
                    d.pagu = $('#pagu').val(),
                    d.pic = $('#pic').val(),
                        d.bulan = $('#bulan').val(),
                        d.tahun = $('#tahun').val(),
                        d.bidang_pekerjaan = $('#bidang_pekerjaan').val(),
                        d.lokasi = $('#lokasi').val(),
                        d.is_pekerjaan_prospek = $('#is_pekerjaan_prospek').val(),
                        d.status_surat = $('#status_surat').val(),
                        d.metode = $('#metode').val(),
                        d.search = $('input[type="search"]').val()
                        
                }
            },

            //data pagu diambil dari sini
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(2).html(new Intl.NumberFormat(["ban", "id"]).format(data.pagu));
            },


            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                 }, {
                    data: 'paket',
                    name: 'paket',
                    orderable: false,
                }, {
                    data: 'pagu',
                    name: 'pagu',
                    orderable: false
                }, {
                    data: 'nama_jenis_pengadaan',
                    name: 'nama_jenis_pengadaan'
                }, {
                    data: 'nama_jenis_produk',
                    name: 'nama_jenis_produk'
                }, {
                    data: 'nama_jenis_usaha',
                    name: 'nama_jenis_usaha'
                }, {
                    data: 'nama_metode_pengadaan',
                    name: 'nama_metode_pengadaan'
                }, {
                    data: 'waktu_pemilihan_penyedia',
                    name: 'waktu_pemilihan_penyedia'
                }, {
                    data: 'klpd',
                    name: 'klpd'
                }, {
                    data: 'satuan_kerja',
                    name: 'satuan_kerja'
                }, {
                    data: 'lokasi_pekerjaan',
                    name: 'lokasi_pekerjaan'
                }, {
                    data: 'id_sis_rup',
                    name: 'id_sis_rup'
                },

            ],

            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$.]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };
                var total = api
                    .column('2')
                    .data()
                    .reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(1).footer()).html('<b>TOTAL</b>');
                $(api.column(2).footer()).html('<b>Rp. ' + new Intl.NumberFormat(["ban", "id"]).format(total) + '</b>');
            },
        });


        $('#pic').change(function() {
            table.draw();
        });
        $('#bulan').change(function() {
            table.draw();
        });
        $('#tahun').change(function() {
            table.draw();
        });
        $('#bidang_pekerjaan').change(function() {
            table.draw();
        });
        $('#lokasi').change(function() {
            table.draw();
        });
        $('#is_pekerjaan_prospek').change(function() {
            table.draw();
        });
        $('#pagu').change(function() {
            table.draw();
        });
        $('#status_surat').change(function() {
            table.draw();
        });
        $('#metode').change(function() {
            table.draw();
        });
    });

    $('#btn-reset').click(function() {
        $('#form-filter')[0].reset();
        table.ajax.reload();
    });
</script>



<script>
    function jadikan_tidak_prospek(id1, id2) {
        Swal.fire({
            title: 'Informasi',
            html: "Anda akan membatalkan pekerjaan <b>"+id2+"</b> yang berstatus <b>PROSPEK</b>. Jika status batal anda tidak bisa mengubahnya kembali.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{url('prospek/ubah-ke-tidak-prospek')}}/" + id1,
                    dataType: "JSON",
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memproses data',
                            html: 'Mohon tunggu sebentar. Sistem sedang menyiapkan request anda.',
                            allowOutsideClick: false,
                            onOpen: () => {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function(data) {
                        if (data.status) {
                            Swal.fire(
                                'Sukses',
                                'Berhasil mengubah status tidak prospek, data anda sudah dihapus pada menu Prospek',
                                'success'
                            );
                            table.ajax.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error updating data!');
                    }
                });
            }
        });
    }


    function delete_data(id1, id2) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: "Anda akan menghapus Prospek <b>" + id2 + "</b> ?",
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
                    url: "{{url('prospek/delete-data')}}/" + id1,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                            table.ajax.reload();
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
@endsection 