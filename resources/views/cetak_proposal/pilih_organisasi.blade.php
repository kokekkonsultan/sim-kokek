@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap"
    rel="stylesheet" />

@endsection

@section('content')
<div class="container-fluid">

    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}</h2>
    </div>


    

    <div class="card card-body mb-5">

        <h5 class="text-primary">Filter Data</h5>
        <hr>
        <br>


        <form id="form-filter">
            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Kategori Instansi</label>
                <div class="col-10">
                    <select id="id_agency_category" name="id_agency_category" class="form-control" multiple="multiple"></select>
                </div>
            </div>


            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Instansi</label>
                <div class="col-10">
                    <select id="id_agency" name="id_agency" class="form-control" multiple="multiple"></select>
                </div>
            </div>


            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Organisasi</label>
                <div class="col-10">
                    <select id="id_organisasi" name="id_organisasi" class="form-control" multiple="multiple" style="width: 100%"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Provinsi</label>
                <div class="col-10">
                    <select id="id_provinsi_indonesia" class="form-control" multiple>
                        @foreach(collect(DB::table('provinsi_indonesia')->select('id_provinsi_indonesia',
                        'nama_provinsi_indonesia')->get()) as $row)
                        <option value="{{$row->id_provinsi_indonesia}}">{{$row->nama_provinsi_indonesia}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="form-label col-2 font-weight-bold">Berdasarkan Surat Ditujukan</label>
                <div class="col-10">
                    <select id="id_surat_ditujukan" name="id_surat_ditujukan" class="form-control" multiple="multiple"></select>
                </div>
            </div>


            <hr>
            <div class="text-right">
                <a href="{{url('cetak-proposal/' . Session::get('id_users'))}}" class="btn btn-secondary font-italic font-weight-bold">Kembali</a>
                <button type="button" id="btn-reset" class="btn btn-secondary font-italic font-weight-bold">Refresh</button>
                <button type="button" id="btn-filter" class="btn btn-secondary font-italic font-weight-bold">Filter</button>
            </div>
        </form>
    </div>


    <div class="card card-body">
        <form class="form_default" method="POST" action="{{url('cetak-proposal/buat-proposal/' . Request::segment(3))}}"
            accept-charset="utf-8">
            @csrf

            <div class="row">
                <div class="checkbox-inline col-6">
                    <label class="checkbox checkbox-lg checkbox-primary">
                        <input type="checkbox" class="checkAll font-weight-bold" name="checkAll" id="checkAll" />
                        <span></span><b class="text-primary">Pilih Semua</b>
                    </label>
                </div>
                <div class="col-6 text-right">
                    <button class="btn btn-primary font-weight-bolder tombolSubmit" type="submit"><i class="fa fa-print"></i> Generate Proposal</button>
                </div>
            </div>

            <hr>

            <div class="table-responsive">
                <table class="table table-hover" id="table" style="font-family: 'Inter', sans-serif;">
                    <thead class="">
                        <tr>
                            <th class="font-weight-bolder">#</th>
                            <th class="font-weight-bolder">Organisasi</th>
                            <th class="font-weight-bolder">Instansi</th>
                            <th class="font-weight-bolder">Provinsi</th>
                            <th class="font-weight-bolder">Surat Ditujukan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="row">
            <div class="col-6">
                <a href="{{url('cetak-proposal/' . Session::get('id_users'))}}" class="btn btn-dark font-weight-bolder"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="col-6 text-right">
                <button class="btn btn-primary font-weight-bolder tombolSubmit" type="submit"><i class="fa fa-print"></i> Generate Proposal</button>
            </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('javascript')
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
$('#id_provinsi_indonesia').select2({placeholder: "Choose tags..."});
// $('select').selectpicker({search : true});
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

        // initComplete: function() {
        //     $('.dataTables_filter input').unbind();
        //     $('.dataTables_filter input').bind('keyup', function(e) {
        //         var code = e.keyCode || e.which;
        //         if (code == 13) {
        //             table.search(this.value).draw();
        //         }
        //     });
        // },

        "ajax": {
            "url": "{{url('cetak-proposal/pilih-organisasi/' . Request::Segment(3))}}",
            "data": function(d) {
                d.id_agency_category = $('select[name="id_agency_category"]').val(),
                    d.id_agency = $('select[name="id_agency"]').val(),
                    d.id_organisasi = $('select[name="id_organisasi"]').val(),
                    d.id_surat_ditujukan = $('select[name="id_surat_ditujukan"]').val(),
                    d.id_provinsi_indonesia = $('#id_provinsi_indonesia').val(),
                    d.search = $('#table_filter :input[type="search"]').val()
            }
        },

        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
        }, {
            data: 'select_organisasi',
            name: 'select_organisasi'
        }, {
            data: 'nama_turunan_organisasi',
            name: 'nama_turunan_organisasi'
        }, {
            data: 'nama_provinsi_indonesia',
            name: 'nama_provinsi_indonesia'
        }, {
            data: 'new_surat_ditujukan',
            name: 'new_surat_ditujukan'
        }],
    });


    $('#btn-filter').click(function() {
        table.draw();
    });

    $('#btn-reset').click(function() {
        $('select[name="id_agency_category"]').val(null).trigger('change');
        $('select[name="id_agency"]').val(null).trigger('change');
        $('select[name="id_organisasi"]').val(null).trigger('change');
        $('#id_provinsi_indonesia').val(null).trigger('change');
        $('select[name="id_surat_ditujukan"]').val(null).trigger('change');
        $('#form-filter')[0].reset();
        table.ajax.reload();
    });
});
</script>


<script>
$(document).ready(function() {
    $('.tombolSubmit').click(function() {
        checked = $("input[type=checkbox]:checked").length;

        if (!checked) {
            alert("Anda harus mencentang setidaknya satu organisasi.");
            return false;
        }
    });
});


$(document).ready(function() {
    $("#checkAll").click(function() {
        $(".child").prop("checked", this.checked);
    });
});
</script>


<script>
$('.form_default').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    // build the ajax call

    Swal.fire({
        title: 'Informasi',
        html: "Apakah anda yakin ingin membuat surat proposal ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                beforeSend: function() {
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
                },
                complete: function() {
                    $('.tombolSubmit').removeAttr('disabled');
                    $('.tombolSubmit').html('<i class="fa fa-print"></i> Generate Proposal');
                },
                success: function(response) {
                    // handle success response
                    toastr["success"]('Data berhasil disimpan');
                    window.setTimeout(function() {
                        location.href =
                            "{{url('cetak-proposal/' . Session::get('id_users'))}}"
                    }, 1000);
                    // table.ajax.reload();
                    // console.log(response.id_proposal_template);
                },
                error: function(response) {
                    alert('Error generate data!');
                },
                contentType: false,
                processData: false
            });
        }
    });
})
</script>

    <script>
        $('#id_organisasi').select2({
            placeholder: "Choose tags...",
            minimumInputLength: 2,
            ajax: {
                url: "{{url('select-filter/ajax_organisasi')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#id_agency_category').select2({
            placeholder: "Choose tags...",
            minimumInputLength: 2,
            ajax: {
                url: "{{url('select-filter/ajax_agency_category')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#id_agency').select2({
            placeholder: "Choose tags...",
            minimumInputLength: 2,
            ajax: {
                url: "{{url('select-filter/ajax_agency')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#id_surat_ditujukan').select2({
            placeholder: "Choose tags...",
            minimumInputLength: 2,
            ajax: {
                url: "{{url('select-filter/ajax_surat_ditujukan')}}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    
    </script>
@endsection