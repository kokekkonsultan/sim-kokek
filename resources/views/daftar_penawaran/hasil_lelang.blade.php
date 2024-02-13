@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap"
    rel="stylesheet">

<style>
.select2-container .select2-selection--single {
    height: 35px;
    font-size: 1rem;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">UBAH DAN PUBLISH HASIL LELANG</h2>
    </div>
    <div class="card card-custom">
        <div class="card-body">


            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Nama Pekerjaan</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{{$dil->nama_pekerjaan}}</div>
            </div>


            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Nama Pemberi Kerja</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{{$dil->pemberi_kerja}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Metode Pengadaan</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{{$dil->nama_metode_pengadaan}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Metode Kualifikasi</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{{$dil->nama_metode_kualifikasi}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Metode Dokumen</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{{$dil->metode_dokumen}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Metode Evaluasi</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{{$dil->nama_metode_evaluasi}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Pagu</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9" id="pagu">{{number_format($dil->pagu,0,",",".")}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Nilai HPS Paket</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9" id="nilai_hps">{{number_format($dil->nilai_hps,0,",",".")}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">PIC</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{{$dil->nama_pic_dil}}</div>
            </div>



            <div class="row">
                <label class="col-sm-2 col-form-label font-weight-bolder">Hasil Lelang</label>
                <div class="col-1 font-weight-bolder">:</div>
                <div class="col-sm-9">{!! $status !!}</div>
            </div>


        </div>



        <div class="card-footer text-center">
            <a class="btn btn-info btn-lg font-weight-bolder"
                href="{{url('daftar-penawaran/' . Session::get('id_users'))}}"><i class="fa fa-arrow-left"></i>
                Kembali</a>
            <a class="btn btn-secondary btn-lg font-weight-bolder" data-toggle="modal" data-target="#ubah_dil"
                data-keyboard="false" data-backdrop="static"><i class="fa fa-edit"></i> Ubah Hasil Lelang</a>

            <!-- <a class="btn btn-primary btn-lg font-weight-bolder" href="{{url('daftar-penawaran/publish/' . Request::segment(3))}}"><i class="fa fa-edit"></i> Publish</a> -->

            
            @if($dil->hasil_lelang != 7)
            <button type="button" class="btn btn-primary btn-lg font-weight-bolder" onclick='publish_dil("{{$dil->nama_pekerjaan}}")'><i class="fa fa-share"></i> Publish Hasil Lelang</button>
            @endif
        </div>
    </div>
</div>




<!-- modal hasil lelang -->
<div class="modal fade" id="ubah_dil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="exampleModalLabel">Ubah Hasil Lelang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
            </div>

            <div class="modal-body">

                <form class="form_default" method="POST"
                    action="{{url('daftar-penawaran/ubah-hasil-lelang/' . Request::segment(3))}}">
                    @csrf

                    <div class="form-group">
                        <label class="col-form-label font-weight-bold">Pilih Status Lelang <b
                                class="text-danger">*</b></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Please Select</option>
                            <option value="1">Menang</option>
                            <option value="2">Kalah</option>
                            <option value="3">Mundur</option>
                            <option value="4">Gugur</option>
                            <option value="5">Lelang Dibatalkan</option>
                            <option value="6">Tidak Lulus Prakualifikasi</option>
                        </select>
                    </div>

                    <div id="menang" style="display: none;">
                        <div class="row">
                            <div class="col-6">
                                <label class="col-form-label font-weight-bold">Nilai Penawaran <b
                                        class="text-danger">*</b></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control form_menang" name="nilai_penawaran"
                                        id="nilai_penawaran" value="">
                                </div>
                                <small class="text-danger">** Nilai Penawaran tidak boleh lebih besar dari Nominal
                                    HPS</small>
                            </div>
                            <div class="col-6">
                                <label class="col-form-label font-weight-bold">Nilai Kontrak <b
                                        class="text-danger">*</b></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" class="form-control form_menang" name="nilai_kontrak"
                                        id="nilai_kontrak" value="">
                                </div>
                                <small class="text-danger">** Nilai Kontrak tidak boleh lebih besar dari Nilai
                                    Penawaran</small>
                            </div>
                        </div>
                    </div>

                    <div id="kalah" style="display: none;">
                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Kompetitor Pemenang <b
                                    class="text-danger">*</b></label>
                            <select class="form-control form_kalah" name="id_kompetitor_pemenang"
                                id="id_kompetitor_pemenang">
                                <option value="">Please Select</option>
                                @foreach(DB::table('kompetitor')->get() as $row)
                                <option value="{{$row->id_kompetitor}}">{{$row->nama}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Alasan Kalah <b
                                    class="text-danger">*</b></label>
                            <textarea class="form-control form_kalah" name="keterangan_alasan_kalah"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Penyebab tidak lolos lelang pada saat
                                prakualifikasi ? <b class="text-danger">*</b></label>
                            <select class="form-control form_kalah" name="penyebab_tidak_lolos_kalah">
                                <option value="">Please Select</option>
                                <option value="KLBI">KLBI</option>
                                <option value="SBU">SBU</option>
                                <option value="Jurusan dan kualifikasi tenaga ahli">Jurusan dan kualifikasi tenaga ahli
                                </option>
                                <option value="Pengalaman 50% dari HPS">Pengalaman 50% dari HPS</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Keterangan Penyebab</label>
                            <textarea class="form-control" name="keterangan_penyebab_kalah"
                                placeholder="Contoh: Tidak lolos karena tenaga ahli, keterangannya S3 Statistik"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Apakah Melakukan Sanggahan ? <b
                                    class="text-danger">*</b></label>
                            <select class="form-control form_kalah" name="status_sanggahan_kalah">
                                <option value="">Please Select</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>

                    </div>

                    <div id="mundur" style="display: none;">
                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Alasan Mundur</label>
                            <textarea class="form-control" name="keterangan_alasan_mundur"></textarea>
                        </div>
                    </div>

                    <div id="gugur" style="display: none;">
                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Alasan Gugur</label>
                            <textarea class="form-control" name="keterangan_alasan_gugur"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Penyebab tidak lolos lelang pada saat
                                prakualifikasi ? <b class="text-danger">*</b></label>
                            <select class="form-control form_gugur" name="penyebab_tidak_lolos_gugur">
                                <option value="">Please Select</option>
                                <option value="KLBI">KLBI</option>
                                <option value="SBU">SBU</option>
                                <option value="Jurusan dan kualifikasi tenaga ahli">Jurusan dan kualifikasi tenaga ahli
                                </option>
                                <option value="Pengalaman 50% dari HPS">Pengalaman 50% dari HPS</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Keterangan Penyebab</label>
                            <textarea class="form-control" name="keterangan_penyebab_gugur"
                                placeholder="Contoh: Tidak lolos karena tenaga ahli, keterangannya S3 Statistik"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Apakah Melakukan Sanggahan ? <b
                                    class="text-danger">*</b></label>
                            <select class="form-control form_gugur" name="status_sanggahan_gugur">
                                <option value="">Please Select</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>

                    <div id="batal" style="display: none;">
                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Alasan Lelang di Batalkan</label>
                            <textarea class="form-control" name="keterangan_alasan_batal"></textarea>
                        </div>
                    </div>

                    <div id="tidak_lulus" style="display: none;">
                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Alasan Tidak Lulus Prakualifikasi</label>
                            <textarea class="form-control" name="keterangan_alasan_tidak_lulus"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Penyebab tidak lolos lelang pada saat
                                prakualifikasi ? <b class="text-danger">*</b></label>
                            <select class="form-control form_tidak_lulus" name="penyebab_tidak_lolos_tidak_lulus">
                                <option value="">Please Select</option>
                                <option value="KLBI">KLBI</option>
                                <option value="SBU">SBU</option>
                                <option value="Jurusan dan kualifikasi tenaga ahli">Jurusan dan kualifikasi tenaga ahli
                                </option>
                                <option value="Pengalaman 50% dari HPS">Pengalaman 50% dari HPS</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Keterangan Penyebab</label>
                            <textarea class="form-control" name="keterangan_penyebab_tidak_lulus"
                                placeholder="Contoh: Tidak lolos karena tenaga ahli, keterangannya S3 Statistik"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label font-weight-bold">Apakah Melakukan Sanggahan ? <b
                                    class="text-danger">*</b></label>
                            <select class="form-control form_tidak_lulus" name="status_sanggahan_tidak_lulus">
                                <option value="">Please Select</option>
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="text-right">
                        <button class="btn btn-secondary font-weight-bolder" data-dismiss="modal"
                            aria-label="Close">Batal</button>
                        <button class="btn btn-primary font-weight-bolder" type="submit">Simpan</button>
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


<script type="text/javascript">
$(document).ready(function() {
    // Format mata uang.
    $('#nilai_kontrak').mask('000.000.000.000', {
        reverse: true
    });
    $('#nilai_penawaran').mask('000.000.000.000', {
        reverse: true
    });
})
</script>

<script type='text/javascript'>
$("#status").change(function() {

    if ($("#status").val() == 1) {
        $('.form_menang').prop('required', true);
        $('.form_kalah').removeAttr('required');
        $('.form_mundur').removeAttr('required');
        $('.form_gugur').removeAttr('required');
        $('.form_batal').removeAttr('required');
        $('.form_tidak_lulus').removeAttr('required');

        $('#menang').show();
        $('#kalah').hide();
        $('#mundur').hide();
        $('#gugur').hide();
        $('#batal').hide();
        $('#tidak_lulus').hide();

    } else if ($("#status").val() == 2) {
        $('.form_menang').removeAttr('required');
        $('.form_kalah').prop('required', true);
        $('.form_mundur').removeAttr('required');
        $('.form_gugur').removeAttr('required');
        $('.form_batal').removeAttr('required');
        $('.form_tidak_lulus').removeAttr('required');

        $('#menang').hide();
        $('#kalah').show();
        $('#mundur').hide();
        $('#gugur').hide();
        $('#batal').hide();
        $('#tidak_lulus').hide();

    } else if ($("#status").val() == 3) {
        $('.form_menang').removeAttr('required');
        $('.form_kalah').removeAttr('required');
        $('.form_mundur').removeAttr('required');
        $('.form_gugur').removeAttr('required');
        $('.form_batal').removeAttr('required');
        $('.form_tidak_lulus').removeAttr('required');

        $('#menang').hide();
        $('#kalah').hide();
        $('#mundur').show();
        $('#gugur').hide();
        $('#batal').hide();
        $('#tidak_lulus').hide();

    } else if ($("#status").val() == 4) {
        $('.form_menang').removeAttr('required');
        $('.form_kalah').removeAttr('required');
        $('.form_mundur').removeAttr('required');
        $('.form_gugur').prop('required', true);
        $('.form_batal').removeAttr('required');
        $('.form_tidak_lulus').removeAttr('required');

        $('#menang').hide();
        $('#kalah').hide();
        $('#mundur').hide();
        $('#gugur').show();
        $('#batal').hide();
        $('#tidak_lulus').hide();

    } else if ($("#status").val() == 5) {
        $('.form_menang').removeAttr('required');
        $('.form_kalah').removeAttr('required');
        $('.form_mundur').removeAttr('required');
        $('.form_gugur').removeAttr('required');
        $('.form_batal').removeAttr('required');
        $('.form_tidak_lulus').removeAttr('required');

        $('#menang').hide();
        $('#kalah').hide();
        $('#mundur').hide();
        $('#gugur').hide();
        $('#batal').show();
        $('#tidak_lulus').hide();

    } else if ($("#status").val() == 6) {
        $('.form_menang').removeAttr('required');
        $('.form_kalah').removeAttr('required');
        $('.form_mundur').removeAttr('required');
        $('.form_gugur').removeAttr('required');
        $('.form_batal').removeAttr('required');
        $('.form_tidak_lulus').prop('required', true);

        $('#menang').hide();
        $('#kalah').hide();
        $('#mundur').hide();
        $('#gugur').hide();
        $('#batal').hide();
        $('#tidak_lulus').show();

    } else {
        $('.form_menang').removeAttr('required');
        $('.form_kalah').removeAttr('required');
        $('.form_mundur').removeAttr('required');
        $('.form_gugur').removeAttr('required');
        $('.form_batal').removeAttr('required');
        $('.form_tidak_lulus').removeAttr('required');

        $('#menang').hide();
        $('#kalah').hide();
        $('#mundur').hide();
        $('#gugur').hide();
        $('#batal').hide();
        $('#tidak_lulus').hide();
    }
});
</script>


<script>
function publish_dil(id) {
        Swal.fire({
            title: 'Informasi',
            html: "Apa anda yakin akan mem-publish pekerjaan <b>" + id + "</b> ?",
            icon: 'question',
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
                    type: "GET",
                    url: "{{url('daftar-penawaran/publish/' . Request::segment(3))}}",
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
                                'Berhasil mem-publish Daftar Informasi Lelang.',
                                'success'
                            );
                            table.ajax.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error publish data!');
                    }
                });
            }
        });
    }
</script>

<!-- <script>
    $(document).ready(function() {
        $("#id_kompetitor_pemenang").select2({
            placeholder: "   Please Select",
            allowClear: true,
            closeOnSelect: true,
        });
    });
</script> -->
@endsection