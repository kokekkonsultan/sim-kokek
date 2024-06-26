@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap" rel="stylesheet">

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
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{!! strtoupper($title) !!}</h2>
    </div>

    <form class="form_default" method="POST" action="{{url('surat-proposal/proses-edit/' . Request::Segment(3))}}">
        @csrf


        <!-- #Bagian Kepala Surat -->
        <div class="card card-body">
            <h6 class="text-primary font-weight-bolder">Bagian Kepala Surat</h6>
            <hr>

            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Surat Proposal Template <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <select class="form-control" name="id_proposal" id="id_proposal" required>
                        <option value="">Please Select</option>
                        @foreach(DB::table('view_master_proposal')->where('nama_jenis_proposal', "$proposal->nama_jenis_proposal")->get() as $row)
                        <option value="{{$row->id}}" {{$row->id == $proposal->id_master_proposal ? 'selected' : ''}}>{{$row->nama_master_proposal . ' (' . $row->nama_jenis_proposal . ')'}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Perihal <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="perihal" value="{{$proposal->perihal}}" required>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Jumlah Lampiran <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <select class="form-control" name="jumlah_lampiran" required>
                        <option value="">Please Select</option>
                        <option value="1 (satu) berkas" selected>1 (satu) berkas</option>
                    </select>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Jenis Instansi <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <select class="form-control" name="id_jenis_instansi_proposal" required>
                        <option value="">Please Select</option>
                        @foreach(DB::table('jenis_instansi_proposal')->get() as $row)
                        <option value="{{$row->id}}" {{$row->id == $proposal->id_jenis_instansi_proposal ? 'selected' : ''}}>{{$row->nama_jenis_instansi_proposal}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- #Bagian Pembuka Surat -->
        <div class="card card-body mt-5">
            <h6 class="text-primary font-weight-bolder">Bagian Pembuka Surat</h6>
            <hr>


            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Isi Pembuka Surat <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="bagian_pembuka_surat" id="tinymce-bagian-pembuka-surat" placeholder="Dengan hormat, Menindaklanjuti Peraturan Menteri Pariwisata dan Ekonomi Kreatif/Bapekraf No. 18 Tahun 2021 tentang Penyelenggaraan Sertifikasi Usaha Pariwisata dan SNI 9042:2021 CHSE yang menggantikan Peraturan Menteri Pariwisata dan Ekonomi Kreatif/Bapekraf No. 13 Tahun 2020, maka sudah seharusnya personil di Dinas Pariwisata wajib memiliki kompetensi terkait dengan proses audit dan Standar Usaha Pariwisata/SNI 9042:2021 CHSE agar dapat melakukan pengawasan.">{!! $proposal->bagian_pembuka_surat !!}</textarea>
                </div>
            </div>
        </div>


        <!-- #Bagian Tubuh Surat -->
        <div class="card card-body mt-5">
            <h6 class="text-primary font-weight-bolder">Bagian Tubuh Surat</h6>
            <hr>

            <!-- #Project -->
            @if($proposal->nama_jenis_proposal == 'Project')
            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Isi Tubuh Surat <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="bagian_tubuh_surat" id="tinymce-bagian-tubuh-surat">{!! $proposal->bagian_tubuh_surat !!}</textarea>
                </div>
            </div>

            <!-- #Public Course -->
            @elseif($proposal->nama_jenis_proposal == 'Public Course')
            <div>

                <div class="form-group row mb-5">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama Kegiatan <b class="text-danger">*</b></label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" name="nama_kegiatan" value="{{$proposal->nama_kegiatan}}" placeholder="Pelatihan Survei Kepuasan Masyarakat Elektronik" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Tanggal <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-5"><input type="date" name="tgl_mulai" class="form-control" value="{{$proposal->tgl_mulai}}"></div>
                            <div class="col-md-1 text-center font-weight-bold">s/d</div>
                            <div class="col-md-5"><input type="date" name="tgl_selesai" class="form-control" value="{{$proposal->tgl_selesai}}"></div>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Jam <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-5"><input type="time" name="jam_mulai" class="form-control" value="{{$proposal->jam_mulai}}"></div>
                            <div class="col-md-1 text-center font-weight-bold">s/d</div>
                            <div class="col-md-5"><input type="time" name="jam_selesai" class="form-control" value="{{$proposal->jam_selesai}}"></div>
                            <div class="col-md-1 font-weight-bold">WIB</div>
                        </div>
                    </div>
                </div>


                <div class="form-group row mb-5">
                    <label class="col-sm-2 col-form-label font-weight-bold">Biaya Kegiatan Per Paket <b class="text-danger">*</b></label>
                    <div class="col-sm-10 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                        </div>
                        <input type="text" class="form-control biaya" name="biaya" value="{{$proposal->biaya}}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">PPN <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <select name="is_ppn" class="form-control">
                            <option value="termasuk PPN" {{$proposal_is_ppn = 'termasuk PPN' ? 'selected' : ''}}>termasuk PPN</option>
                            <option value="tidak termasuk PPN" {{$proposal_is_ppn = 'tidak termasuk PPN' ? 'selected' : ''}}>tidak termasuk PPN</option>
                            <option value="tidak dikenakan PPN" {{$proposal_is_ppn = 'tidak dikenakan PPN' ? 'selected' : ''}}>tidak dikenakan PPN</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Tempat Kegiatan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="tempat_kegiatan" class="form-control"  placeholder="Online Training" value="{{$proposal->tempat_kegiatan}}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Fasilitas <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="fasilitas" class="form-control" required="required" placeholder="Materi dan Sertifikat Pelatihan (tidak termasuk tempat dan konsumsi)" value="{{$proposal->fasilitas}}">

                    </div>
                </div>

                <div class="form-group row">
                    <label for="catatan" class="col-sm-2 col-form-label font-weight-bold">Catatan</label>
                    <div class="col-sm-10">
                        <textarea name="catatan" cols="40" rows="10" id="catatan" class="form-control form-control-sm">{{$proposal->catatan}}</textarea>
                        <small id="" class="form-text text-muted">Jika diisi akan ditampilkan pada kolom catatan proposal.</small>
                    </div>
                </div>
            </div>


            <!-- #In House Training -->
            @elseif($proposal->nama_jenis_proposal == 'In House Training')
            <div>

                <div class="form-group row mb-5">
                    <label class="col-sm-2 col-form-label font-weight-bold">Nama Kegiatan <b class="text-danger">*</b></label>
                    <div class="col-sm-10 input-group">
                        <input type="text" class="form-control" name="nama_kegiatan" value="{{$proposal->nama_kegiatan}}" placeholder="Pelatihan Survei Kepuasan Masyarakat Elektronik" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Jumlah Hari Kegiatan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <select name="jumlah_hari" class="form-control">
                            <option>Please Select</option>
                            @for($x = 1; $x <= 5; $x++)
                            <option value="{{$x}} (satu) hari" {{$proposal->jumlah_hari == "$x (satu) hari" ? 'selected' : ''}}>{{$x}} (satu) hari</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Jam <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-md-5"><input type="time" name="jam_mulai" class="form-control" value="{{$proposal->jam_mulai}}"></div>
                            <div class="col-md-1 text-center font-weight-bold">s/d</div>
                            <div class="col-md-5"><input type="time" name="jam_selesai" class="form-control" value="{{$proposal->jam_selesai}}"></div>
                            <div class="col-md-1 font-weight-bold">WIB</div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Biaya Kegiatan Per Paket <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Rp. </label>
                            </div>
                            <input type="text" name="biaya" class="form-control biaya" value="{{$proposal->biaya}}" required>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">PPN <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <select name="is_ppn" class="form-control">
                            <option value="termasuk PPN" {{$proposal_is_ppn = 'termasuk PPN' ? 'selected' : ''}}>termasuk PPN</option>
                            <option value="tidak termasuk PPN" {{$proposal_is_ppn = 'tidak termasuk PPN' ? 'selected' : ''}}>tidak termasuk PPN</option>
                            <option value="tidak dikenakan PPN" {{$proposal_is_ppn = 'tidak dikenakan PPN' ? 'selected' : ''}}>tidak dikenakan PPN</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Jumlah maximal peserta <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <select name="max_peserta" class="form-control">
                            <option>Please Select</option>
                            @for ($i = 1; $i < 40; $i++)
                            <option value="{{$i}} orang" {{"$i orang" == $proposal->max_peserta ? 'selected' : ''}}>{{$i}} Orang</option>
                                @endfor
                        </select>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Kelebihan Peserta Biaya <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Rp. </label>
                            </div>
                            <input type="text" name="kelebihan_peserta_biaya" class="form-control biaya" value="{{$proposal->kelebihan_peserta_biaya}}" required>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Tempat Kegiatan <b class="text-danger">*</b></label>
                    <div class="col-sm-10">
                        <input type="text" name="tempat_kegiatan" id="tempat_kegiatan" class="form-control" required="required" placeholder="Online Training" value="{{$proposal->tempat_kegiatan}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label font-weight-bold">Fasilitas <b class="text-danger">*</b></label>
                    <div class="col-sm-10">

                        <input type="text" name="fasilitas" id="fasilitas" class="form-control" required="required" placeholder="Materi dan Sertifikat Pelatihan (tidak termasuk tempat dan konsumsi)" value="{{$proposal->fasilitas}}">

                    </div>
                </div>

                <div class="form-group row">
                    <label for="catatan" class="col-sm-2 col-form-label font-weight-bold">Catatan</label>
                    <div class="col-sm-10">
                        <textarea name="catatan" cols="40" rows="10" data="catatan" id="catatan" class="form-control form-control-sm">{{$proposal->catatan}}</textarea>
                        <small id="" class="form-text text-muted">Jika diisi akan ditampilkan pada kolom catatan proposal.</small>
                    </div>
                </div>
            </div>

            <!-- #Custom -->
            @else
            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Isi Tubuh Surat <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="bagian_tubuh_surat" id="tinymce-bagian-tubuh-surat"></textarea>
                </div>
            </div>

            @endif
        </div>


        <!-- #Bagian Penutup Surat -->
        <div class="card card-body mt-5">
            <h6 class="text-primary font-weight-bolder">Bagian Penutup Surat</h6>
            <hr>


            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Isi Penutup Surat <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="bagian_penutup_surat" id="tinymce-bagian-penutup-surat" placeholder="KOKEK Consulting telah banyak bekerjasama dengan Kementerian/Lembaga, Pemerintah Daerah, Perusahaan BUMN, dan BUMD dalam rangka peningkatan sistem manajemen maupun sumber daya manusia. KOKEK Consulting juga telah mendapatkan lisensi dari PECB (Kanada) untuk training standar internasional. Demikian penawaran dari kami, jika Bapak/Ibu berminat bisa menghubungi kami di marketing@kokek.com atau WhatsApp 0895 2681 4555. Atas perhatian dan kerjasamanya kami sampaikan terima kasih.">{!! $proposal->bagian_penutup_surat !!}</textarea>
                </div>
            </div>
        </div>


         <!-- #Style Surat -->
         <div class="card card-body mt-5">
            <h6 class="text-primary font-weight-bolder">Style Surat</h6>
            <hr>

            <div class="form-group row mb-5">
                <label class="col-sm-2 col-form-label font-weight-bold">Ukuran Font <b class="text-danger">*</b></label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" max="11" min="6" name="font_size" value="{{$proposal->font_size}}" placeholder="Masukkan ukuran font untuk template surat." step="0.1" required>
                    <small class="text-danger">** Gunakan titik (.) untuk menggantikan koma (,) jika font yang anda masukkan berbentuk desimal</small>
                </div>
            </div>
        </div>


        <div class="text-right mt-5 mb-5">
            <a class="btn btn-secondary font-weight-bolder" href="{{url('surat-proposal/' . Session::get('id_users'))}}">Kembali</a>
            <button type="submit" class="btn btn-primary font-weight-bolder">Submit</button>
        </div>
    </form>
</div>


@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{asset('assets/themes/metronic/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
<script src="{{asset('assets/themes/metronic/js/pages/crud/forms/editors/tinymce.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Format mata uang.
        $('.biaya').mask('000.000.000.000', {
            reverse: true
        });
    })


    $(document).ready(function() {
        $("#id_proposal").select2({
            placeholder: "   Please Select",
            allowClear: true,
            closeOnSelect: true,
        });
    });
</script>


<script>
    // TINY MCE
    // Class definition
    var KTTinymce = function() {
        // Private functions
        var demos = function() {

            tinymce.init({
                selector: '#tinymce-bagian-pembuka-surat',
                menubar: false,
                statusbar: false,
                branding: false,
                toolbar: ['undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | code'],
                plugins: 'advlist autolink link image lists charmap print preview code',
                // setup: function(editor) {
                //     editor.on('change', function() {
                //         tinymce.triggerSave();
                //     });
                // }
            });

            tinymce.init({
                selector: '#tinymce-bagian-tubuh-surat',
                menubar: false,
                statusbar: false,
                branding: false,
                toolbar: ['undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | code'],
                plugins: 'advlist autolink link image lists charmap print preview code'
            });

            tinymce.init({
                selector: '#tinymce-bagian-penutup-surat',
                menubar: false,
                statusbar: false,
                branding: false,
                toolbar: ['undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | code'],
                plugins: 'advlist autolink link image lists charmap print preview code'
            });
            tinymce.init({
                selector: '#catatan',
                menubar: false,
                statusbar: false,
                branding: false,
                toolbar: ['undo redo | cut copy paste | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | code'],
                plugins: 'advlist autolink link image lists charmap print preview code'
            });
        }

        return {
            // public functions
            init: function() {
                demos();
            }
        };
    }();

    // Initialization
    jQuery(document).ready(function() {
        KTTinymce.init();
    });
</script>
@endsection