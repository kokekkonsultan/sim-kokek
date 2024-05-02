@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{!! strtoupper('Edit Formulir Informasi
            Pekerjaan') !!}</h2>
    </div>



    <!-- BIAYA PERSONIL ================================= -->
    <div class="card card-body mb-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Biaya Personil</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_biaya"><i
                        class="fa fa-plus"></i> Tambah Biaya Personil</a>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-bordered example" style="width:100%">
                <thead>
                    <tr class="bg-secondary">
                        <th>#</th>
                        <th>Uraian</th>
                        <th>Vol 1</th>
                        <th>Sat 1</th>
                        <th>Vol 2</th>
                        <th>Sat 2</th>
                        <th>Vol 3</th>
                        <th>Sat 3</th>
                        <th>Harga Satuan (Rp.)</th>
                        <th>Jumlah (Rp.)</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $a = 1;
                    @endphp
                    @foreach(DB::table('fip_biaya')->where(['id_fip' => $fip->id_fip, 'id_jenis_fip_biaya' => 1])->get() as $value)
                    <tr>
                        <td>{{$a++}}</td>
                        <td>{{$value->uraian}}</td>
                        <td>{{$value->volume1}}</td>
                        <td>{{$value->satuan1}}</td>
                        <td>{{$value->volume2}}</td>
                        <td>{{$value->satuan2}}</td>
                        <td>{{$value->volume3}}</td>
                        <td>{{$value->satuan3}}</td>
                        <td>{{($value->harga_satuan)? number_format($value->harga_satuan,0,',','.') : '-'}}</td>
                        <td>{{($value->jumlah)? number_format($value->jumlah,0,',','.') : '-'}}</td>
                        <td>{{$value->keterangan}}</td>
                        <td><a class="btn btn-light-primary btn-icon mr-1" data-toggle="modal"
                                onclick="showEditBiaya('{{$value->id_fip_biaya}}')" href="#modal_edit_biaya"><i
                                    class="fa fa-edit"></i></a>

                            <button class="btn btn-light-danger btn-icon" href="javascript:void(0)"
                                onclick="delete_biaya('{{$value->id_fip_biaya}}')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- BIAYA NON PERSONIL ================================= -->
    <div class="card card-body mb-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Biaya Non Personil</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_biaya"><i
                        class="fa fa-plus"></i> Tambah Biaya Non Personil</a>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-bordered example" style="width:100%">
                <thead>
                    <tr class="bg-secondary">
                        <th>#</th>
                        <th>Uraian</th>
                        <th>Vol 1</th>
                        <th>Sat 1</th>
                        <th>Vol 2</th>
                        <th>Sat 2</th>
                        <th>Vol 3</th>
                        <th>Sat 3</th>
                        <th>Harga Satuan (Rp.)</th>
                        <th>Jumlah (Rp.)</th>
                        <th>Keterangan</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $a = 1;
                    @endphp
                    @foreach(DB::table('fip_biaya')->where(['id_fip' => $fip->id_fip, 'id_jenis_fip_biaya' => 2])->get() as $value)
                    <tr>
                        <td>{{$a++}}</td>
                        <td>{{$value->uraian}}</td>
                        <td>{{$value->volume1}}</td>
                        <td>{{$value->satuan1}}</td>
                        <td>{{$value->volume2}}</td>
                        <td>{{$value->satuan2}}</td>
                        <td>{{$value->volume3}}</td>
                        <td>{{$value->satuan3}}</td>
                        <td>{{($value->harga_satuan)? number_format($value->harga_satuan,0,',','.') : '-'}}</td>
                        <td>{{($value->jumlah)? number_format($value->jumlah,0,',','.') : '-'}}</td>
                        <td>{{$value->keterangan}}</td>
                        <td><a class="btn btn-light-primary btn-icon mr-1" data-toggle="modal"
                                onclick="showEditBiaya('{{$value->id_fip_biaya}}')" href="#modal_edit_biaya"><i
                                    class="fa fa-edit"></i></a>

                            <button class="btn btn-light-danger btn-icon" href="javascript:void(0)"
                                onclick="delete_biaya('{{$value->id_fip_biaya}}')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Catatan Marketing ================================= -->
    <div class="card card-body mb-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Catatan Marketing</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_catatan_marketing"><i
                        class="fa fa-plus"></i> Tambah Catatan Marketing</a>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-bordered example" style="width:100%">
                <thead class="bg-secondary">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th>Isi Catatan</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $b = 1;
                    @endphp
                    @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 1])->get() as $value)
                    <tr>
                        <td>{{$b++}}</td>
                        <td>{{$value->tanggal_catatan}}</td>
                        <td>{!! $value->isi_catatan !!}</td>
                        <td>
                            <a class="btn btn-light-primary btn-icon mr-1" data-toggle="modal"
                            onclick="showEditCatatan('{{$value->id_catatan_fip}}')" href="#modal_edit_catatan"><i class="fa fa-edit"></i></a>
                            
                            <button class="btn btn-light-danger btn-icon" href="javascript:void(0)"
                                onclick="delete_catatan('{{$value->id_catatan_fip}}')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <!-- Catatan General Manager ================================= -->
    <div class="card card-body mb-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Catatan General Manager</h6>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-bordered example" style="width:100%">
                <thead class="bg-secondary">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th>Isi Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $c = 1;
                    @endphp
                    @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 2])->get() as $value)
                    <tr>
                        <td>{{$c++}}</td>
                        <td>{{$value->tanggal_catatan}}</td>
                        <td>{!! $value->isi_catatan !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <!-- Catatan Admin Proyek ================================= -->
    <div class="card card-body mb-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Catatan Admin Proyek</h6>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-bordered example" style="width:100%">
                <thead class="bg-secondary">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th>Isi Catatan</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $d = 1;
                    @endphp
                    @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 3])->get() as $value)
                    <tr>
                        <td>{{$d++}}</td>
                        <td>{{$value->tanggal_catatan}}</td>
                        <td>{!! $value->isi_catatan !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <!-- Catatan Direksi ================================= -->
    <div class="card card-body mb-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Catatan Direksi</h6>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover table-bordered example" style="width:100%">
                <thead class="bg-secondary">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th>Isi Catatan</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $e = 1;
                    @endphp
                    @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 4])->get() as $value)
                    <tr>
                        <td>{{$e++}}</td>
                        <td>{{$value->tanggal_catatan}}</td>
                        <td>{!! $value->isi_catatan !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    
    <!-- Tanggapan ================================= -->
    <div class="card card-body mb-5">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary font-weight-bold">Tanggapan</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_tanggapan"><i class="fa fa-plus"></i> Tambah Tanggapan</a>
            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-hover example" style="width:100%">
                <thead class="">
                    <tr>
                        <th></th>
                        <th width="80%"></th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(DB::table('tanggapan_fip')->where(['id_fip' => $fip->id_fip, 'tanggapan_dihapus' => 0])->get() as $value)
                    <tr>
                        <td>
                            @php
                            $users = DB::table('users')->where('id', $value->id_user)->first();
                            echo '<b>' . $users->first_name . ' ' . $users->last_name . '</b><br>';
                            echo '<small>' . date('d-m-Y h:i:s', strtotime($value->tanggal_tanggapan_fip)) . '</small>'
                            @endphp
                        </td>
                        <td>{{$value->isi_tanggapan}}</td>
                        <td>
                            <button class="btn btn-light-dark btn-icon" href="javascript:void(0)"
                                onclick="delete_tanggapan('{{$value->id_tanggapan_fip}}')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
    <div class="col-6">
        <a class="btn btn-secondary btn-block font-weight-bold" href="{{url('fip-mkt/form-edit/' . $fip->id_fip)}}">Kembali</a>
    </div>
    <div class="col-6">
        <a class="btn btn-primary btn-block font-weight-bold" href="{{url('fip-mkt/' . Session::get('id_users'))}}">Simpan Data</a>
    </div>
    </div>

    <!-- <div class="text-right">
        <a class="btn btn-secondary font-weight-bold" href="{{url('fip-mkt/edit/' . $fip->id_fip)}}">Kembali</a>
        <a class="btn btn-primary font-weight-bold" href="{{url('fip-mkt/' . Session::get('id_users'))}}">Simpan Data</a>
    </div> -->

    

</div>


@include('fip_mkt/biaya/modal_add')
@include('fip_mkt/catatan_marketing/modal_add')

<!-- ======================================= MODAL EDIT BIAYA ========================================== -->
<div class="modal fade" id="modal_edit_biaya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h6 class="font-weight-bold">Ubah Biaya</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="bodyModalEditBiaya">
                <div align="center" id="loading_registration">
                    <i class='fa fa-spin fa-spinner' style='font-size:50px;'></i>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ======================================= MODAL CATATAN ========================================== -->
<div class="modal fade" id="modal_edit_catatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h6 class="font-weight-bold">Ubah Catatan Marketing</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body" id="bodyModalCatatan">
                <div align="center" id="loading_registration">
                    <i class='fa fa-spin fa-spinner' style='font-size:50px;'></i>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- ======================================= MODAL ADD TANGGAPAN ========================================== -->
<div class="modal fade" id="add_tanggapan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tanggapan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">

                <form class="form_default" method="POST" action="{{url('fip-mkt/add-tanggapan')}}">
                    @csrf

                    <input name="id_fip" value="{{$fip->id_fip}}" hidden>

                    <div class="form-group row">
                        <label class="col-3 col-form-label font-weight-bold">Isi Catatan <b class="text-danger">*</b></label>
                        <div class="col-9">
                            <textarea class="form-control" name="isi_tanggapan" rows="4"></textarea>
                        </div>
                    </div>

                    <hr>
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary tombolCancel" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary font-weight-bold tombolSubmit" type="submit">Simpan</button>
                    </div>

                </form>
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
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<script>
$(document).ready(function() {
    $('.example').DataTable();
});
</script>


<script>
$(".hitung").keyup(function() {
    var volume1 = $("#volume1").val() == 0 ? 1 : $("#volume1").val();
    var volume2 = $("#volume2").val() == 0 ? 1 : $("#volume2").val();
    var volume3 = $("#volume3").val() == 0 ? 1 : $("#volume3").val();
    var harga_satuan = $("#harga_satuan").val();
    var total = (volume1 * volume2 * volume3) * harga_satuan;

    // console.log(total);
    $("#jumlah").val(new Intl.NumberFormat(["ban", "id"]).format(total));
});


function showEditBiaya(id) {
    $('#bodyModalEditBiaya').html(
        "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size:25px;'></i></div>");

    $.ajax({
        type: "get",
        url: "{{url('fip-mkt/modal-edit-biaya')}}/" + id,
        dataType: "text",
        success: function(response) {
            $('#bodyModalEditBiaya').empty();
            $('#bodyModalEditBiaya').append(response);
        }
    });
}

function delete_biaya(id) {
    if (confirm('Anda akan menghapus data ini ?')) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{url('fip-mkt/delete-biaya')}}/" + id,
            dataType: "JSON",
            success: function(data) {
                if (data.status === true) {
                    Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
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



<script>
ClassicEditor
    .create(document.querySelector('#isi_catatan'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });


function showEditCatatan(id) {
    $('#bodyModalCatatan').html(
        "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size:25px;'></i></div>");

    $.ajax({
        type: "get",
        url: "{{url('fip-mkt/modal-edit-catatan')}}/" + id,
        dataType: "text",
        success: function(response) {
            $('#bodyModalCatatan').empty();
            $('#bodyModalCatatan').append(response);
        }
    });
}


function delete_catatan(id) {
    if (confirm('Anda akan menghapus data ini ?')) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{url('fip-mkt/delete-catatan')}}/" + id,
            dataType: "JSON",
            success: function(data) {
                if (data.status === true) {
                    Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
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


<script>
    function delete_tanggapan(id) {
    if (confirm('Anda akan menghapus data ini ?')) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "{{url('fip-mkt/delete-tanggapan')}}/" + id,
            dataType: "JSON",
            success: function(data) {
                if (data.status === true) {
                    Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
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



<script>
$('.form_default').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    // build the ajax call
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        beforeSend: function() {
            $('.tombolCancel').attr('disabled', 'disabled');
            $('.tombolSubmit').attr('disabled', 'disabled');
            $('.tombolSubmit').html(
                '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
        },
        complete: function() {
            $('.tombolCancel').removeAttr('disabled');
            $('.tombolSubmit').removeAttr('disabled');
            $('.tombolSubmit').html('Simpan');
        },
        success: function(response) {
            Swal.fire(
                'Sukses',
                'Berhasil menambah data.',
                'success'
            );
            setTimeout( function(){
                    location.reload();
                }, 1200);
        },
        error: function(response) {
            alert('Error menambah data.');
            table.ajax.reload();
        },
        contentType: false,
        processData: false
    });
})
</script>




<!-- 
<script>
$('#id_marketing').select2({
    placeholder: "Please Select",
    width: '100%'
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    // Format mata uang.
    $('#harga_satuan').mask('000.000.000.000', {
        reverse: true
    });
})
</script>
 -->
@endsection