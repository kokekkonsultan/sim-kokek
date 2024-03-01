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
                <div class="col-6 text-right">
                    <a class="btn btn-info font-weight-bold" data-toggle="collapse" href="#filter"><i class="fa fa-filter"></i> Filter Data</a>
                    <a class="btn btn-primary font-weight-bold" href="{{url('daftar-penawaran/form-add-tanpa-rup')}}"><i class="fa fa-plus"></i> Tambah Daftar Penawaran</a>

                    <!-- <a class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Daftar Penawaran</a> -->
                </div>
            </div>

            <hr>

            <div class="collapse mb-5" id="filter">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Tahun Anggaran</label>
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
                                <label class="form-label text-info font-weight-bolder">Status Lelang</label>
                                <select id='status_lelang' class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="1">Menang</option>
                                    <option value="2">Kalah</option>
                                    <option value="3">Mundur</option>
                                    <option value="4">Gugur</option>
                                    <option value="5">Lelang Dibatalkan</option>
                                    <option value="6">Tidak Lulus Prakualifikasi</option>
                                    <option value="7">Sedang Berjalan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Melalui RUP</label>
                                <select id='id_is_sirup' class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Pagu Minimal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control form_rupiah" id="pagu_min">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Pagu Maximal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control form_rupiah" id="pagu_max">
                                </div>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Nilai HPS Minimal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control form_rupiah" id="nilai_hps_min">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="form-label text-info font-weight-bolder">Nilai HPS Maximal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control form_rupiah" id="nilai_hps_max">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <br>

            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table" style="font-family: 'Inter', sans-serif;">
                    <thead class="">
                        <tr class="bg-secondary">
                            <th><b>#</b></th>
                            <th><b>Nama Pekerjaan</b></th>
                            <th><b>Pemberi Kerja / Pengguna Jasa</b></th>
                            <th width="15%"><b>Metode</b></th>
                            <!-- <th><b>Metode Pengadaan</b></th>
                            <th><b>Metode Kualifikasi</b></th>
                            <th><b>Metode Dokumen</b></th>
                            <th><b>Metode Evaluasi</b></th> -->
                            <th><b>Pokja</b></th>
                            <th><b>Nilai Pagu (Rp.)</b></th>
                            <th><b>Nilai HPS Paket (Rp.)</b></th>
                            <th><b>Hasil Lelang / Keterangan</b></th>
                            <th><b>PIC</b></th>
                            <th><b>Melalui RUP</b></th>
                            <th><b>Keterangan Lelang</b></th>
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
<!-- <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih cara anda menambahkan RUP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-deck">
                    <a href="{{url('daftar-penawaran/form-add-dengan-rup')}}" class="card card-body btn btn-outline-primary shadow">
                        <div class="text-center font-weight-bold">
                            <i class="fa fa-edit"></i><br><b>MELALUI RUP</b>
                            <p class="text-dark">Data Pekerjaan yang sebelumya telah di inputkan melalui menu Rencana Umum Pengadaan (RUP)</p>
                        </div>
                    </a>

                    <a href="{{url('daftar-penawaran/form-add-tanpa-rup')}}" class="card card-body btn btn-outline-primary shadow">
                        <div class="text-center font-weight-bold">
                            <i class="fas fa-plus"></i><br><b>TANPA MELALUI RUP</b>
                            <p class="text-dark">Data Pekerjaan yang bisa anda masukkan ke dalam data Daftar Penawaran secara langsung</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> -->


<!-- Modal Add Proposal -->
<div class="modal fade" id="add-surat" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <form class="form_default" method="POST" action="{{url('daftar-penawaran/add-proposal')}}">
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
                "url": "{{url('daftar-penawaran/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
                "data": function(d) {
                    d.tahun = $('#tahun').val(),
                        d.status_lelang = $('#status_lelang').val(),
                        d.id_is_sirup = $('#id_is_sirup').val(),
                        d.search = $('input[type="search"]').val(),
                        d.pagu_min = $('#pagu_min').val(),
                        d.pagu_max = $('#pagu_max').val(),
                        d.nilai_hps_min = $('#nilai_hps_min').val(),
                        d.nilai_hps_max = $('#nilai_hps_max').val()
                }
            },

            //data pagu diambil dari sini
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(5).html(new Intl.NumberFormat(["ban", "id"]).format(data
                    .nilai_pekerjaan));
                $('td', row).eq(6).html(new Intl.NumberFormat(["ban", "id"]).format(data.nilai_hps));
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'paket',
                    name: 'paket',
                    orderable: false
                }, {
                    data: 'nama_pemberi_kerja',
                    name: 'nama_pemberi_kerja',
                    orderable: false
                }, {
                    data: 'metode',
                    name: 'metode',
                    orderable: false
                },
                {
                    data: 'pokja',
                    name: 'pokja'
                }, {
                    data: 'nilai_pekerjaan',
                    name: 'nilai_pekerjaan',
                    orderable: false
                }, {
                    data: 'nilai_hps',
                    name: 'nilai_hps',
                    orderable: false
                }, {
                    data: 'status',
                    name: 'status',
                    orderable: false
                }, {
                    data: 'nama_pic_dil',
                    name: 'nama_pic_dil'
                }, {
                    data: 'nama_is_sirup',
                    name: 'nama_is_sirup'
                }, {
                    data: 'keterangan_lelang',
                    name: 'keterangan_lelang'
                },

            ],
        });

        $('#status_lelang').change(function() {
            table.draw();
        });
        $('#id_is_sirup').change(function() {
            table.draw();
        });
        $('#tahun').change(function() {
            table.draw();
        });
        $('#pagu_min').change(function() {
            table.draw();
        });
        $('#pagu_max').change(function() {
            table.draw();
        });
        $('#nilai_hps_min').change(function() {
            table.draw();
        });
        $('#nilai_hps_max').change(function() {
            table.draw();
        });
    });

    $('#btn-reset').click(function() {
        $('#form-filter')[0].reset();
        table.ajax.reload();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Format mata uang.
        $('.form_rupiah').mask('000.000.000.000', {
            reverse: true
        });
    })
</script>


<script>
    function aanwizing(id) {
        var url = "{{url('daftar-penawaran/form-jadwal-lelang')}}/" + id;
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            html: '<div>Silahkan lengkapi pengisian <b>Jadwal Aanwizing</b> di menu Jadwal Lelang terlebih dahulu sebelum melanjutkan ke tahap berikutnya.</div>',
            showConfirmButton: true,
            // showCancelButton: true,
            // cancelButtonText: 'Batal',
            // confirmButtonColor: '#3085d6',
            // cancelButtonColor: '#d33',
            // confirmButtonText: 'Lengkapi Jadwal',
            // allowOutsideClick: false,
        // })
        // .then((object) => {
        //     if (object.value) {
        //         window.open(url, '_blank');
        //     }
        });
    }

    function lengkapi_data(id) {
        var url = "{{url('daftar-penawaran/form-edit')}}/" + id;
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            html: '<div>Silahkan lengkapi pengisian <b>Data pekerjaan</b> di menu Edit terlebih dahulu sebelum melanjutkan ke tahap berikutnya.</div>',
            showConfirmButton: true,
        //     showCancelButton: true,
        //     cancelButtonText: 'Lewati',
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Lengkapi Data Pekerjaan',
        //     allowOutsideClick: false,
        // }).then((object) => {
        //     if (object.value) {
        //         window.open(url, '_blank');
        //     }
        });
    }
</script>


<script>
    function delete_data(id1, id2) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: "Anda akan menghapus data DIL <b>" + id2 + "</b> ?",
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
                    url: "{{url('daftar-penawaran/delete-data')}}/" + id1,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status === true) {
                            Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                            table.ajax.reload();
                        }

                        if (data.status === false) {
                            Swal.fire('Error',
                                'Tidak dapat menghapus, data Daftar Penawaran digunakan di Daftar Proyek Berjalan DPB',
                                'error');
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