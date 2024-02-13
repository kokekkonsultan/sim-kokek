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
                    <a class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Surat Proposal</a>
                </div>
            </div>
            <hr>
            <p>Menu Surat Proposal digunakan untuk melengkapi isian dari bentuk proposal pada Menu Proposal yang sebelumnya sudah ditambahkan.
                Untuk membuat surat proposal anda harus memilih jenis proposal terlebih dahulu, antara lain : Project, Public Course, In House Training, Custom.</p>

           


            <br>

            <div class="table-responsive">
                <table class="table table-hover" id="table" style="font-family: 'Inter', sans-serif;">
                    <thead class="">
                        <tr>
                            <th class="font-weight-bolder">No.</th>
                            <th class="font-weight-bolder">Surat Proposal</th>
                            <th class="font-weight-bolder">Jenis Proposal</th>
                            <th class="font-weight-bolder">Produk</th>
                            <th class="font-weight-bolder">Pemerintah/ Swasta</th>
                            <th class="font-weight-bolder">Dibuat Pada</th>
                            <th class="font-weight-bolder" width="22%"></th>
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
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                @foreach(DB::select('SELECT * FROM jenis_proposal WHERE id != 1') as $row)
                <a href="{{url('surat-proposal/form-add/' . $row->id)}}" class="btn btn-light-primary font-weight-bold">{{$row->nama_jenis_proposal}}</a>
                @endforeach
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
                "url": "{{url('surat-proposal/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
                "data": function(d) {}
            },

            //data pagu diambil dari sini
            "fnCreatedRow": function(row, data, index) {
                $('td', row).eq(5).html(new Date(data.created_at).toLocaleDateString());
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'nama_master_proposal',
                    name: 'nama_master_proposal'
                }, {
                    data: 'nama_jenis_proposal',
                    name: 'nama_jenis_proposal'
                }, {
                    data: 'nama_bidang_pekerjaan',
                    name: 'nama_bidang_pekerjaan'
                }, {
                    data: 'nama_jenis_instansi_proposal',
                    name: 'nama_jenis_instansi_proposal'
                }, {
                    data: 'created_at',
                    name: 'created_at'
                }, {
                    data: 'btn',
                    name: 'btn'
                }

            ],
        });
    });

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
                    url: "{{url('surat-proposal/delete-data')}}/" + id1,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status === true) {
                            Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                            table.ajax.reload();
                        }

                        if (data.status === false) {
                            Swal.fire('Error', 'Tidak dapat menghapus, data Daftar Penawaran digunakan di Daftar Proyek Berjalan DPB', 'error');
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