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
    /* height: 35px; */
    font-size: 1rem;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{!! strtoupper($title . '<br>' .
            $jenis_pekerjaan) !!}</h2>
    </div>

    <form class="form_default" method="POST" action="{{url('dpb/proses-add/' . Request::segment(3))}}">
        @csrf

        <div class="card card-body">

            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Deskripsi Pekerjaan</h6>
                </div>
            </div>
            <hr>




            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Kode <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="number" class="form-control bg-light" value="{{$kode_dpb}}" name="kode_dpb" readonly
                        required>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Jenis Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control bg-light" value="{{$jenis_pekerjaan}}" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Tahun DPB <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control bg-light" value="{{$tahun_dpb}}" name="tahun_dpb" readonly
                        required>
                </div>
            </div>




            <!-- JIKA DPB DARI LELANG -->
            @if($jenis_pekerjaan == 'Lelang')
            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Pilih DIL <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control" name="id_dil" id="id_dil" required autofocus>
                        <option value="">Please Select</option>

                        @foreach(DB::select("SELECT *
                        FROM data_dil_marketing
                        WHERE NOT EXISTS (SELECT * FROM daftar_proyek_berjalan WHERE daftar_proyek_berjalan.id_dil =
                        data_dil_marketing.id_dil) && hasil_lelang = 1") as $value)

                        <option value="{{$value->id_dil}}">
                            {{$value->nama_pekerjaan . ' - Tahun anggaran : ' . $value->pembebanan_tahun_anggaran . ' - PIC : ' . $value->nama_pic_dil}}
                        </option>

                        @endforeach

                    </select>
                </div>
            </div>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pemberi Kerja <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="pemberi_kerja" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_pekerjaan" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Bidang/ Sub Bidang Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="bidang_pekerjaan" disabled>
                </div>
            </div>

            @else

            <!-- JIKA BUKAN DARI LELANG -->
            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pemberi Kerja <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control id_organisasi" name="id_pemberi_kerja" id="id_organisasi" required
                        autofocus></select>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Bidang/ Sub Bidang Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control" name="id_bidang_pekerjaan" id="id_bidang_pekerjaan" required>
                        <option value="">Please Select</option>

                        @foreach(DB::table('bidang_pekerjaan')->get() as $row)
                        <option value="{{$row->id_bidang_pekerjaan}}">{{$row->nama_bidang_pekerjaan}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nama_pekerjaan"
                        placeholder="Masukkan nama pekerjaan.." required>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Tahun Anggaran <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control" name="tahun_anggaran" required>
                        <option value="">Please Select</option>
                        @for ($x = (date('Y') - 1); $x <= (date('Y') + 5); $x++) <option value="{{$x}}">{{$x}}</option>
                            @endfor
                    </select>
                </div>
            </div>

            @endif


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Lokasi Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="lokasi_pekerjaan"
                        placeholder="Masukkan lokasi pekerjaan.." required>
                </div>
            </div>
        </div>


        <div class="card card-body mt-5">

            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Kontrak</h6>
                </div>
            </div>
            <hr>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nomor Kontrak <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nomor_kontrak" placeholder="Masukkan nomor kontrak.."
                        required>
                    <small class="text-danger">** Jika kontrak belum diterima, Nomor Kontrak bisa diisi dengan XXXXX
                        terlebih dahulu.</small>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Tanggal Kontrak <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9 input-group">
                    <input type="text" class="form-control datetimepicker-input date" name="tanggal_kontrak"
                        id="tanggal_kontrak" placeholder="Tentukan tanggal kontrak.." data-toggle="datetimepicker"
                        data-target="#datetimepicker-single" autocomplete="off" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Durasi Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class='col-sm-9 input-group' id='kt_daterangepicker_2'>
                    <input class="form-control readonly" id="durasi_pekerjaan" name="durasi_pekerjaan" type="text"
                        style="width: 300px;" placeholder="Pilih rentang tanggal durasi pekerjaan" required
                        autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                    </div>
                </div>
            </div>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nilai Pekerjaan <b
                        class="text-danger">*</b></label>
                <div class="col-sm-9 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                    </div>
                    <input type="text" class="form-control" name="nilai_pekerjaan" id="nilai_pekerjaan"
                        placeholder="Masukkan nilai pekerjaan yang tertera pada kontrak..." required>
                </div>
            </div>
        </div>


        <div class="card card-body mt-5">

            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Jenis Pajak</h6>
                </div>
            </div>
            <hr>

            <div class="alert alert-info" role="alert">
                Pemilihan jenis pajak akan mempengaruhi nilai: <b>Dasar pengenaan Pajak (DPP)</b>, <b>Pajak Pertambahan
                    Nilai (PPN)</b> dan <b>Pajak Penghasilan (PPh)</b> yang terdapat pada menu Omzet. Pahami dahulu
                definisi dari setiap jenis pajak tersebut agar tidak salah menentukan jenis pajak. Jika anda sangat
                tidak paham bisa berkonsultasi pada bagian keuangan.
            </div>

            <div class="alert alert-secondary" role="alert">
                <b>Termasuk PPN</b> : Jika Anda memilih Termasuk PPN ini, maka nilai PPN dan PPh akan dihitung. Anda
                wajib mengisi besar nilai persentase pajak, misalnya 11%.<br>
                <b>Tidak termasuk PPN</b> : Jika Anda memilih Tidak termasuk PPN, maka nilai PPN adalah 0 dan nilai PPh
                akan dihitung.<br>
                <b>Tanpa PPN</b> : Jika Anda memilih Tanpa PPN, maka nilai PPN adalah 0, nilai PPh adalah 0 dan nilai
                DPP disamakan dengan Nilai Pekerjaan.<br>
            </div>

            <br>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Pajak <b class="text-danger">*</b></label>
                <div class="col-9">

                    <div class="radio-list">
                        <label class="radio">
                            <input type="radio" name="jenis_pajak" id="1" value="1" class="pajak"
                                required><span></span>Termasuk PPN
                        </label>
                        <label class="radio">
                            <input type="radio" name="jenis_pajak" id="2" value="2" class="pajak"><span></span>Tidak
                            Termasuk PPN
                        </label>
                        <label class="radio">
                            <input type="radio" name="jenis_pajak" id="3" value="3" class="pajak"><span></span> Tanpa
                            PPN
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row" id="display_persentase_pajak" style="display: none;">
                <label class="col-3 col-form-label font-weight-bold">Besar Persentase Pajak <b
                        class="text-danger">*</b></label>
                <div class="col-9">
                    <input type="number" id="persentase_pajak" name="persentase_pajak" class="form-control"
                        placeholder="11">
                </div>
            </div>
        </div>


        <!-- <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Objek Pekerjaan</h6>
                </div>
            </div>
            <hr>

            <div class="alert alert-secondary" role="alert">Jika objek pekerjaan sangat banyak, anda bisa mengisi bidang
                dibawah ini. Namun Anda tetap diwajibkan mengisi bidang Objek Pekerjaan yang asli pada tahap
                selanjutnya. Bidang ini dipakai agar data pengalaman pekerjaan tidak panjang.</div>
            <br>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Persingkat Objek Pekerjaan ? <b
                        class="text-danger">*</b></label>
                <div class="radio-list col-9">
                    <label class="radio radio-primary">
                        <input type="radio" class="font-weight-bold is_objek_pekerjaan_alias"
                            name="is_objek_pekerjaan_alias" value="1" required>
                        <span></span> Ya
                    </label>

                    <label class="radio radio-primary">
                        <input type="radio" class="font-weight-bold is_objek_pekerjaan_alias"
                            name="is_objek_pekerjaan_alias" value="0">
                        <span></span> Tidak
                    </label>
                </div>
            </div>


            <div class="form-group row" id="display_objek_pekerjaan_alias" style="display: none;">
                <label class="col-3 col-form-label font-weight-bold">Nama Objek Pekerjaan Dipersingkat <b
                        class="text-danger">*</b></label>
                <div class="radio-list col-9">
                    <textarea class="form-control" name="objek_pekerjaan_alias" id="objek_pekerjaan_alias"></textarea>
                </div>
            </div>
        </div> -->



        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Pengurus (Isikan salah satu)</h6>
                </div>
            </div>
            <hr>


            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Nama PPK</label>
                <div class="radio-list col-9">
                    <select class="form-control pengurus" name="id_ppk"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Nama PPTK</label>
                <div class="radio-list col-9">
                    <select class="form-control pengurus" name="id_pptk"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Nama KPA</label>
                <div class="radio-list col-9">
                    <select class="form-control pengurus" name="id_kpa"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Nama PA</label>
                <div class="radio-list col-9">
                    <select class="form-control pengurus" name="id_pa"></select>
                </div>
            </div>
        </div>


        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Catatan DPB</h6>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Keterangan
                    <small class="form-text text-muted">Jika ada catatan untuk informasi pekerjaan ini atau perubahan
                        apapun, anda dapat input di bidang ini untuk memberikan informasi mengenai DPB ini.</small>
                </label>
                <div class="radio-list col-9">
                    <textarea class="form-control" name="keterangan_dpb" rows="5"></textarea>
                </div>
            </div>
        </div>


        <div class="text-right mt-5">
            <a class="btn btn-secondary font-weight-bold" href="{{url('dpb/' . Session::get('id_users'))}}">Kembali</a>
            <button type="submit" class="btn btn-primary font-weight-bold">Selanjutnya</button>

        </div>


    </form>


</div>


@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>


<script>
$(function() {
    $(":radio.pajak").click(function() {
        if ($(this).val() == 1) {
            $("#display_persentase_pajak").show();
            $("#persentase_pajak").prop('required', true);
        } else if ($(this).val() == 2) {
            $("#display_persentase_pajak").hide();
            $("#persentase_pajak").removeAttr('required');
        } else if ($(this).val() == 3) {
            $("#display_persentase_pajak").hide();
            $("#persentase_pajak").removeAttr('required');
        }
    });
});

// $(function() {
//     $(":radio.is_objek_pekerjaan_alias").click(function() {
//         if ($(this).val() == 1) {
//             $("#display_objek_pekerjaan_alias").show();
//             $("#objek_pekerjaan_alias").prop('required', true);
//         } else {
//             $("#display_objek_pekerjaan_alias").hide();
//             $("#objek_pekerjaan_alias").removeAttr('required');
//         }
//     })
// });
</script>


<script>
$('#id_organisasi').select2({
    placeholder: "Please Select...",
    width: "100%",
    minimumInputLength: 2,
    ajax: {
        url: "{{url('select-filter/ajax_organisasi')}}",
        dataType: 'json',
        data: function(params) {
            return {
                q: $.trim(params.term)
            };
        },
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
});

$('.pengurus').select2({
    placeholder: "Please Select...",
    width: "100%",
    ajax: {
        url: "{{url('select-filter/ajax_contact_person')}}",
        dataType: 'json',
        data: function(params) {
            return {
                q: $.trim(params.term)
            };
        },
        processResults: function(data) {
            return {
                results: data
            };
        },
        cache: true
    }
});
</script>


<script>
$('#id_dil').select2({
    placeholder: "Please Select",
    width: '100%'
});
$('#id_bidang_pekerjaan').select2({
    placeholder: "Please Select",
    width: '100%'
});
$('#id_dil').change(function() {
    var id = $(this).val();
    $.ajax({
        url: "{{ url('dpb/cari-id-dil') }}/" + id,
        type: 'get',
        dataType: 'json',
        success: function(data) {
            $('#pemberi_kerja').val(data.pemberi_kerja);
            $('#nama_pekerjaan').val(data.nama_pekerjaan);
            $('#bidang_pekerjaan').val(data.nama_bidang_pekerjaan);
            $('#nilai_pekerjaan').val(new Intl.NumberFormat(["ban", "id"]).format(data
                .nilai_kontrak));
        }
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    // Format mata uang.
    $('#nilai_pekerjaan').mask('000.000.000.000', {
        reverse: true
    });
})
</script>


<script type="text/javascript">
$(function() {
    $('#tanggal_kontrak').datetimepicker({
        format: "DD-MM-YYYY",
        locale: 'id'
    });
});
</script>

<script>
var KTBootstrapDaterangepicker = function() {
    // Private functions
    var demos = function() {
        // input group and left alignment setup
        $('#kt_daterangepicker_2').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary'
        }, function(start, end, label) {
            $('#kt_daterangepicker_2 .form-control').val(start.format('YYYY-MM-DD') + ' / ' + end
                .format('YYYY-MM-DD'));
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();
jQuery(document).ready(function() {
    KTBootstrapDaterangepicker.init();
});
</script>
@endsection