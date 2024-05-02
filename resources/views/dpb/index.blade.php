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
                <div class="col-6 text-right">
                    <a data-toggle="modal" data-target="#export" class="btn btn-light-success font-weight-bolder mr-2"><i class="fa fa-file-excel"></i> Export Excel</a>

                    <a type="button" class="btn btn-light-info font-weight-bold mr-2" data-toggle="collapse" href="#filter"><i class="fa fa-filter"></i>Filter Data</a>

                    <a data-toggle="modal" data-target="#add" class="btn btn-primary font-weight-bolder"><i class="fa fa-plus"></i> Tambah DPB</a>
                </div>
            </div>

            <div class="collapse mb-5" id="filter">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-4 form-group">
                            <label class="form-label text-info font-weight-bolder">Tahun DPB</label>
                            <select id='tahun' class="form-control">
                                <option value="">Please Select</option>
                                @for ($x = date('Y'); $x >= 2004; $x--)
                                <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- <div class="col-4 form-group">
                            <label class="form-label text-info font-weight-bolder">Bidang Pekerjaan</label>
                            <select id='id_bidang_pekerjaan' class="form-control">
                                <option value="">Please Select</option>
                                @foreach(DB::table('bidang_pekerjaan')->get() as $row)
                                <option value="{{$row->id_bidang_pekerjaan}}">{{$row->id_bidang_pekerjaan . ' ' . $row->nama_bidang_pekerjaan}}</option>
                                @endforeach
                            </select>
                        </div> -->
                    </div>
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
                            <th>Jenis</th>
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
                            <th>Keterangan DPB</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- MODAL ADD -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light-primary">
                <h5 class="modal-title" id="exampleModalLabel">Pilih cara anda untuk menambah DPB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach(DB::table('jenis_pekerjaan')->get() as $row)
                    <div class="col-6 mb-5">
                        <a href="{{url('dpb/form-add/' . $row->id_jenis_pekerjaan)}}" class="card card-body btn btn-outline-primary shadow">
                            <div class="text-center font-weight-bolder">{{strtoupper($row->nama_jenis_pekerjaan)}}</div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL EXPORT EXCEL -->
<div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light-success">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Periode Tahun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="GET" action="{{url('dpb/export')}}" target="_blank">
                    <div class="form-group row mb-5">
                        <label class="col-sm-3 col-form-label font-weight-bold">Mulai <b class="text-danger">*</b></label>
                        <div class='col-sm-9'>

                            <select class="form-control" name="mulai" placeholder="Pilih rentang tahun.." required>
                                <option value="">Please Select</option>
                                @for ($x = date('Y'); $x >= 2004; $x--)
                                <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-5">
                        <label class="col-sm-3 col-form-label font-weight-bold">Sampai <b class="text-danger">*</b></label>
                        <div class='col-sm-9'>

                            <select class="form-control" name="sampai" placeholder="Pilih rentang tahun.." required>
                                <option value="">Please Select</option>
                                @for ($x = date('Y'); $x >= 2004; $x--)
                                <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <br>
                    <hr>

                    <div class="text-right">
                        <button class="btn btn-secondary btn-sm font-weight-bold tombolCancel" data-dismiss="modal" aria-label="Close">Batal</button>
                        <button class="btn btn-primary btn-sm font-weight-bold tombolSubmit" type="submit">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- ======================================= EDIT TANGGAL TERIMA KONTRAK ========================================== -->
<div class="modal fade" id="modal_terima_kontrak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="font-weight-bold">Tanggal Terima Kontrak</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="bodyModalTerimaKontrak">
                <div align="center" id="loading_registration">
                    <i class='fa fa-spin fa-spinner' style='font-size:50px;'></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================= EDIT TANGGAL SURAT REFERENSI ========================================== -->
<div class="modal fade" id="modal_terima_surat_referensi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="font-weight-bold">Tanggal Terima Surat Referensi</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="bodyModalTerimaSuratReferensi">
                <div align="center" id="loading_registration">
                    <i class='fa fa-spin fa-spinner' style='font-size:50px;'></i>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ======================================= INFO PERUBAHAN DPB ========================================== -->
<div class="modal fade" id="modal_info_perubahan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="font-weight-bold">Informasi Perubahan Terakhir DPB</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="bodyModalInfoPerubahan">
                <div align="center" id="loading_registration">
                    <i class='fa fa-spin fa-spinner' style='font-size:50px;'></i>
                </div>
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
                    d.tahun = $('#tahun').val(),
                        d.id_bidang_pekerjaan = $('#id_bidang_pekerjaan').val(),
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
                }, {
                    data: 'jenis_pekerjaan_dpb',
                    name: 'jenis_pekerjaan_dpb'
                }, {
                    data: 'nama_bidang_pekerjaan',
                    name: 'nama_bidang_pekerjaan'
                }, {
                    data: 'pemberi_kerja',
                    name: 'pemberi_kerja'
                }, {
                    data: 'nama_pekerjaan_dpb',
                    name: 'nama_pekerjaan_dpb'
                }, {
                    data: 'nilai_kontrak_dpb',
                    name: 'nilai_kontrak_dpb'
                }, {
                    data: 'jumlah_termin_pembayaran',
                    name: 'jumlah_termin_pembayaran'
                }, {
                    data: 'durasi_kontrak_pekerjaan',
                    name: 'durasi_kontrak_pekerjaan'
                }, {
                    data: 'tanggal_terima_kontrak',
                    name: 'tanggal_terima_kontrak'
                }, {
                    data: 'tanggal_terima_surat_referensi',
                    name: 'tanggal_terima_surat_referensi'
                }, {
                    data: 'tgl_terima_bast',
                    name: 'tgl_terima_bast'
                }, {
                    data: 'pic_dpb',
                    name: 'pic_dpb'
                }, {
                    data: 'updated',
                    name: 'updated'
                }, {
                    data: 'keterangan_dpb',
                    name: 'keterangan_dpb'
                }

            ],
        });
        $('#tahun').change(function() {
            table.draw();
        });
        $('#id_bidang_pekerjaan').change(function() {
            table.draw();
        });

    });
</script>


<script>
    function showTerimaKontrak(id) {
        $('#bodyModalTerimaKontrak').html(
            "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size:25px;'></i></div>");

        $.ajax({
            type: "get",
            url: "{{url('dpb/modal_tanggal_terima_kontrak')}}/" + id,
            dataType: "text",
            success: function(response) {
                $('#bodyModalTerimaKontrak').empty();
                $('#bodyModalTerimaKontrak').append(response);
            }
        });
    }

    function showTerimaSuratReferensi(id) {
        $('#bodyModalTerimaSuratReferensi').html(
            "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size:25px;'></i></div>");

        $.ajax({
            type: "get",
            url: "{{url('dpb/modal_tanggal_terima_surat_referensi')}}/" + id,
            dataType: "text",
            success: function(response) {
                $('#bodyModalTerimaSuratReferensi').empty();
                $('#bodyModalTerimaSuratReferensi').append(response);
            }
        });
    }

    function showInfoPerubahan(id) {
        $('#bodyModalInfoPerubahan').html(
            "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size:25px;'></i></div>");

        $.ajax({
            type: "get",
            url: "{{url('dpb/modal_info_perubahan')}}/" + id,
            dataType: "text",
            success: function(response) {
                $('#bodyModalInfoPerubahan').empty();
                $('#bodyModalInfoPerubahan').append(response);
            }
        });
    }
</script>


<script>
    function publish(id) {
        Swal.fire({
            title: 'Informasi',
            html: "Dengan menekan Ya, berarti anda telah mengisi data DPB dengan benar dan system akan meneruskan informasi ini melalui pemberitahuan email. Apakah anda akan melanjutkan ?",
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
                    url: "{{url('dpb/publish')}}/" + id,
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
                                'Berhasil melakukan publish DPB',
                                'success'
                            );
                            table.ajax.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Sistem mengalami gangguan, mohon ulangi kembali.');
                    }
                });
            }
        });
    }
</script>

@endsection