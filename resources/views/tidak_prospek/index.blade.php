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
                </div>
            </div>

            <hr>


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
                "url": "{{url('tidak-prospek/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
                "data": function(d) {
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
                    name: 'paket'
                }, {
                    data: 'pagu',
                    name: 'pagu'
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
    });

    $('#btn-reset').click(function() {
        $('#form-filter')[0].reset();
        table.ajax.reload();
    });
</script>



<script>
    function jadikan_prospek(id1, id2) {
        Swal.fire({
            title: 'Informasi',
            html: "Anda akan mengubah pekerjaan <b>" + id2 + "</b> menjadi status <b>PROSPEK</b>",
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

                    
                    url: "{{url('tidak-prospek/ubah-ke-prospek')}}/" + id1,
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
                                'Berhasil mengubah status prospek, data anda sudah ada pada menu Prospek',
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


    function jadikan_rup(id1, id2) {
        Swal.fire({
            title: 'Informasi',
            html: "Anda akan mengubah pekerjaan <b>" + id2 + "</b> menjadi status <b>TIDAK PROSPEK</b>. Data Rup tidak prospek akan dipindahkan ke menu Tidak Prospek.",
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
                    url: "{{url('tidak-prospek/ubah-ke-rup')}}/" + id1,
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
                                'Berhasil mengubah status tidak prospek, data anda sudah dihapus pada menu RUP',
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
</script>
@endsection 