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
                    <a class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#add"><i class="fa fa-print"></i> Cetak Proposal</a>
                </div>
            </div>
            <hr>
            <br>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="table" style="font-family: 'Inter', sans-serif;">
                    <thead class="">
                        <tr>
                            <th class="font-weight-bolder">No.</th>
                            <th class="font-weight-bolder"></th>
                            <th class="font-weight-bolder">Template Proposal</th>
                            <th class="font-weight-bolder">Jumlah Lampiran</th>
                            <th class="font-weight-bolder">Jenis Proposal</th>
                            <th class="font-weight-bolder">Kode Surat</th>
                            <th class="font-weight-bolder">Jumlah Surat</th>
                            <th class="font-weight-bolder"></th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Proposal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label class="col-form-label font-weight-bold">Pilih Proposal Template <b class="text-danger">*</b></label>
                    <select name="id_proposal_template" id="id_proposal_template" class="form-control form-select" required>
                        <option value="">Please Select</option>
                        @foreach(DB::table('view_proposal_template')->get() as $row)
                        <option value="{{$row->id_proposal_template}}">
                            {{$row->nama_master_proposal . ' (' . $row->nama_jenis_proposal . ')'}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary font-weight-bold tombolCancel" data-dismiss="modal" aria-label="Close">Batal</button>
                <button class="btn btn-primary font-weight-bold tombolSubmit" type="submit" id="send_url">Selanjutnya</button>
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
                "url": "{{url('cetak-proposal/' . Request::segment(2))}}", // memanggil route yang menampilkan data json
                "data": function(d) {}
            },

            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'btn_pdf',
                    name: 'btn_pdf'
                }, {
                    data: 'nama_proposal',
                    name: 'nama_proposal'
                },
                {
                    data: 'jumlah_lampiran',
                    name: 'jumlah_lampiran'
                }, {
                    data: 'nama_jenis_proposal',
                    name: 'nama_jenis_proposal'
                }, {
                    data: 'kode_surat',
                    name: 'kode_surat'
                }, {
                    data: 'jumlah_surat',
                    name: 'jumlah_surat'
                }, {
                    data: 'btn_delete',
                    name: 'btn_delete'
                }
            ],
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#id_proposal_template").select2({
            placeholder: "   Please Select",
            allowClear: true,
            closeOnSelect: true,
            width: '100%'
        });
    });
</script>

<script>
    $(function() {
        // bind change event to select
        $('#send_url').on('click', function() {
            var val_id = $('#id_proposal_template').val(); // get selected value
            if (val_id) { // require a URL

                $('.tombolCancel').attr('disabled', 'disabled');
                $('.tombolSubmit').attr('disabled', 'disabled');
                $('.tombolSubmit').html(
                    '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');

                Swal.fire({
                    title: 'Memproses data',
                    html: 'Mohon tunggu sebentar. Sistem sedang menyiapkan request anda.',
                    allowOutsideClick: false,
                    onOpen: () => {
                        swal.showLoading()
                    }
                });

                window.location.href = "{{url('cetak-proposal/pilih-organisasi')}}/" + val_id; // redirect
            }
            return false;
        });
    });
</script>


<script>
    function delete_data(id) {
        if (confirm('Anda akan menghapus data ini ?')) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('cetak-proposal/delete-data')}}/" + id,
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