@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

<style>
    .select2-container .select2-selection--single {
        /* height: 35px; */
        font-size: 1rem;
    }

    .dataTables_length {
        display: none
    }

    .dataTables_filter {
        display: none
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{!! strtoupper($title . '<br>' .
            $dpb->jenis_pekerjaan_dpb) !!}</h2>
    </div>

    <form method="POST" action="{{url('dpb/proses-edit/' . Request::segment(3))}}">
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
                    <input type="number" class="form-control bg-light" value="{{$dpb->kode_dpb}}" name="kode_dpb" readonly required>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Jenis Pekerjaan <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control bg-light" value="{{$dpb->jenis_pekerjaan_dpb}}" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Tahun DPB <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control bg-light" value="{{$dpb->tahun_dpb}}" name="tahun_dpb" readonly required>
                </div>
            </div>




            <!-- JIKA DPB DARI LELANG -->
            @if($dpb->jenis_pekerjaan_dpb == 'Lelang')

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pemberi Kerja <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="pemberi_kerja" value="{{$dpb->nama_pemberi_kerja}}" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="nama_pekerjaan" value="{{$dpb->nama_pekerjaan}}" disabled>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Bidang/ Sub Bidang Pekerjaan <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="bidang_pekerjaan" value="{{$dpb->nama_bidang_pekerjaan}}" disabled>
                </div>
            </div>


            @else
            <!-- JIKA BUKAN DARI LELANG -->
            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pemberi Kerja <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control id_pemberi_kerja" name="id_pemberi_kerja" id="id_pemberi_kerja" required autofocus></select>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Bidang/ Sub Bidang Pekerjaan <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control" name="id_bidang_pekerjaan" id="id_bidang_pekerjaan" required>
                        <option value="">Please Select</option>

                        @foreach(DB::table('bidang_pekerjaan')->get() as $row)
                        <option value="{{$row->id_bidang_pekerjaan}}" {{$dpb->id_bidang_pekerjaan_dpb == $row->id_bidang_pekerjaan ? 'selected' : ''}}>
                            {{$row->nama_bidang_pekerjaan}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nama Pekerjaan <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nama_pekerjaan" placeholder="Masukkan nama pekerjaan.." value="{{$dpb->nama_pekerjaan}}" required>
                </div>
            </div>

            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Tahun Anggaran <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <select class="form-control" name="tahun_anggaran" required>
                        <option value="">Please Select</option>
                        @for ($x = (date('Y') - 1); $x <= (date('Y') + 5); $x++) <option value="{{$x}}" {{$dpb->tahun_anggaran == $x ? 'selected' : ''}}>{{$x}}</option>
                            @endfor
                    </select>
                </div>
            </div>

            @endif


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Lokasi Pekerjaan <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="lokasi_pekerjaan" placeholder="Masukkan lokasi pekerjaan.." value="{{$dpb->lokasi_pekerjaan}}" required>
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
                <label class="col-sm-3 col-form-label font-weight-bold">Nomor Kontrak <b class="text-danger">*</b></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nomor_kontrak" value="{{$dpb->nomor_kontrak}}" placeholder="Masukkan nomor kontrak.." required>
                    <small class="text-danger">** Jika kontrak belum diterima, Nomor Kontrak bisa diisi dengan XXXXX
                        terlebih dahulu.</small>
                </div>
            </div>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Tanggal Kontrak <b class="text-danger">*</b></label>
                <div class="col-sm-9 input-group">
                    <input type="text" class="form-control datetimepicker-input date" name="tanggal_kontrak" id="tanggal_kontrak" placeholder="Tentukan tanggal kontrak.." data-toggle="datetimepicker" data-target="#datetimepicker-single" value="{{date('Y-m-d', strtotime($dpb->tanggal_kontrak))}}" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>


            @php
            $start_date = date('Y-m-d', strtotime($dpb->jangka_waktu_mulai));
            $end_date = date('Y-m-d', strtotime($dpb->jangka_waktu_selesai));
            @endphp
            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Durasi Pekerjaan <b class="text-danger">*</b></label>
                <div class='col-sm-9 input-group' id='kt_daterangepicker_2'>
                    <input class="form-control readonly" id="durasi_pekerjaan" name="durasi_pekerjaan" type="text" style="width: 300px;" placeholder="Pilih rentang tanggal durasi pekerjaan" value="{{$start_date . ' / ' . $end_date}}" required autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                    </div>
                </div>
            </div>


            <div class="form-group row mb-5">
                <label class="col-sm-3 col-form-label font-weight-bold">Nilai Pekerjaan <b class="text-danger">*</b></label>
                <div class="col-sm-9 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                    </div>
                    <input type="text" class="form-control" name="nilai_pekerjaan" value="{{$dpb->nilai_kontrak}}" id="nilai_pekerjaan" placeholder="Masukkan nilai pekerjaan yang tertera pada kontrak..." required>
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
                            <input type="radio" name="jenis_pajak" value="1" class="pajak" required {{$dpb->jenis_pajak == 1 ? 'checked' : ''}}><span></span>Termasuk PPN
                        </label>
                        <label class="radio">
                            <input type="radio" name="jenis_pajak" value="2" class="pajak" {{$dpb->jenis_pajak == 2 ? 'checked' : ''}}><span></span>Tidak
                            Termasuk PPN
                        </label>
                        <label class="radio">
                            <input type="radio" name="jenis_pajak" value="3" class="pajak" {{$dpb->jenis_pajak == 3 ? 'checked' : ''}}><span></span> Tanpa PPN
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row" id="display_persentase_pajak" {!! $dpb->jenis_pajak == 1 ? '' : 'style="display: none;"' !!}>
                <label class="col-3 col-form-label font-weight-bold">Besar Persentase Pajak <b class="text-danger">*</b></label>
                <div class="col-9">
                    <input type="number" id="persentase_pajak" name="persentase_pajak" value="{{$dpb->besaran_persentase_pajak}}" class="form-control" placeholder="11" {{$dpb->jenis_pajak == 1 ? 'required' : ''}}>
                </div>
            </div>
        </div>

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
                    <select class="form-control pengurus" name="id_ppk" id="id_ppk"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Nama PPTK</label>
                <div class="radio-list col-9">
                    <select class="form-control pengurus" name="id_pptk" id="id_pptk"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Nama KPA</label>
                <div class="radio-list col-9">
                    <select class="form-control pengurus" name="id_kpa" id="id_kpa"></select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Nama PA</label>
                <div class="radio-list col-9">
                    <select class="form-control pengurus" name="id_pa" id="id_pa"></select>
                </div>
            </div>
        </div>



        @php
        $a = 1;
        $b = 1;
        $c = 1;
        @endphp

        <!-- TERMIN PEMBAYARAN -->
        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Termin Pembayaran</h6>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_termin"><i class="fa fa-plus"></i> Tambah Termin Pembayaran</a>
                </div>
            </div>
            <hr>

            <table class="table table-hover table-bordered example" style="width:100%">
                <thead>
                    <tr class="bg-secondary">
                        <th width="5%">No</th>
                        <th>%</th>
                        <th>Jumlah</th>
                        <th>Syarat Pembayaran**</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach(DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $id)->get() as $row)
                    <tr>
                        <td>{{$a++}}</td>
                        <td>{{$row->persentase_pembayaran}}</td>
                        <td>Rp. {{number_format($row->harga_pembayaran,0,",",".")}}</td>
                        <td>{{$row->syarat_pembayaran}}</td>
                        <td>
                            <button class="btn btn-light-danger btn-icon" href="javascript:void(0)" onclick="delete_termin('{{$row->id_termin_pembayaran}}')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <!-- TENAGA AHLI -->
        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Tenaga Ahli</h6>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_tenaga_ahli"><i class="fa fa-plus"></i> Tambah Tenaga Ahli</a>
                </div>
            </div>
            <hr>

            <table class="table table-hover table-bordered example" style="width:100%">
                <thead>
                    <tr class="bg-secondary">
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Lead</th>
                        <th>Uraian Tugas</th>
                        <th>Nomor Surat Referensi</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach(DB::select("SELECT *, (SELECT nama_lengkap FROM person_personal_data JOIN tenaga_ahli ON
                    tenaga_ahli.id_person = person_personal_data.id_person WHERE tenaga_ahli.id_tenaga_ahli =
                    tenaga_ahli_proyek_berjalan.id_tenaga_ahli) AS nama_lengkap

                    FROM tenaga_ahli_proyek_berjalan
                    LEFT JOIN proyek_berjalan_uraian_tugas ON tenaga_ahli_proyek_berjalan.id_tg_ahli_proyek_berjalan =
                    proyek_berjalan_uraian_tugas.id_tg_ahli_proyek_berjalan
                    WHERE id_dpb = $id") as $row)
                    <tr>
                        <td>{{$b++}}</td>
                        <td>{{$row->nama_lengkap}}</td>
                        <td>{{$row->posisi_pekerjaan}}</td>
                        <td>{{$row->is_lead == 1 ? 'Ya' : 'Tidak'}}</td>
                        <td>{{$row->uraian_tugas}}</td>
                        <td>{{$row->nomor_surat_referensi}}</td>
                        <td>
                            <a class="btn btn-light-primary btn-icon" data-toggle="modal" data-target="#edit_tenaga_ahli{{$row->id_tg_ahli_proyek_berjalan}}"><i class="fa fa-edit"></i></a>

                            <button class="btn btn-light-danger btn-icon" href="javascript:void(0)" onclick="delete_tenaga_ahli('{{$row->id_tg_ahli_proyek_berjalan}}')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <!-- OBJEK PEKERJAAN -->
        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Objek Pekerjaan</h6>
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-secondary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_objek_pekerjaan"><i class="fa fa-plus"></i> Tambah Objek Pekerjaan</a>
                </div>
            </div>
            <hr>

            <table class="table table-hover table-bordered example" style="width:100%">
                <thead>
                    <tr class="bg-secondary">
                        <th width="5%">No</th>
                        <th>Objek Pekerjaan</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach(DB::select("SELECT *, (SELECT branch_name FROM branch_agency WHERE id_branch_agency =
                    objek_pekerjaan.organization) AS nama_organisasi
                    FROM objek_pekerjaan WHERE id_dpb = $id") as $row)
                    <tr>
                        <td>{{$c++}}</td>
                        <td>{{$row->nama_organisasi}}</td>
                        <td>
                            <a class="btn btn-light-primary btn-icon" data-toggle="modal" data-target="#edit_objek_pekerjaan{{$row->id_objek_pekerjaan}}"><i class="fa fa-edit"></i></a>

                            <button class="btn btn-light-danger btn-icon" href="javascript:void(0)" onclick="delete_objek_pekerjaan('{{$row->id_objek_pekerjaan}}')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="alert alert-custom alert-notice alert-light-info fade show mb-5 mt-5" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">
                    <span>Jika objek pekerjaan sangat banyak, anda bisa mengisi bidang dibawah ini. Namun Anda tetap
                        diwajibkan mengisi bidang Objek Pekerjaan yang asli pada tahap selanjutnya. Bidang ini dipakai
                        agar
                        data pengalaman pekerjaan tidak panjang.</span>
                </div>
            </div>
            <br>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Persingkat Objek Pekerjaan ? <b class="text-danger">*</b></label>
                <div class="radio-list col-9">
                    <label class="radio radio-primary">
                        <input type="radio" class="font-weight-bold is_objek_pekerjaan_alias" name="is_objek_pekerjaan_alias" value="1" required {{$dpb->is_objek_pekerjaan_alias == 1 ? 'checked' : ''}}>
                        <span></span> Ya
                    </label>

                    <label class="radio radio-primary">
                        <input type="radio" class="font-weight-bold is_objek_pekerjaan_alias" name="is_objek_pekerjaan_alias" value="0" {{$dpb->is_objek_pekerjaan_alias == 0 ? 'checked' : ''}}>
                        <span></span> Tidak
                    </label>
                </div>
            </div>

            <div class="form-group row" id="display_objek_pekerjaan_alias" {!! $dpb->is_objek_pekerjaan_alias==1?'':'style="display: none;"' !!}>
                <label class="col-3 col-form-label font-weight-bold">Nama Objek Pekerjaan Dipersingkat <b class="text-danger">*</b></label>
                <div class="radio-list col-9">
                    <textarea class="form-control" name="objek_pekerjaan_alias" id="objek_pekerjaan_alias" {{$dpb->is_objek_pekerjaan_alias == 1 ? 'required' : ''}}>{{$dpb->objek_pekerjaan_alias}}</textarea>
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
                    <textarea class="form-control" name="keterangan_dpb" rows="5">{{$dpb->keterangan_dpb}}</textarea>
                </div>
            </div>
        </div>


        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Perubahan DPB</h6>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Keterangan Perubahan
                    <small class="form-text text-muted">Tuliskan catatan perubahan DPB yang anda buat untuk
                        menginformasikan perubahan yang ada pada DPB ini.</small>
                </label>
                <div class="radio-list col-9">
                    <textarea class="form-control" name="keterangan_perubahan" rows="4" required></textarea>
                </div>
            </div>


            @php
            $no = 1;
            $riwayat_dpb = DB::table("data_perubahan_dpb")->where('id_dpb', $id);
            @endphp
            @if($riwayat_dpb->count() > 0)
            <div class="form-group">
                <label class="col-form-label font-weight-bold text-primary">Riwayat Perubahan DPB
                    <hr>
                </label>
                <table class="table table-striped table-striped example" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Keterangan Perubahan</th>
                            <th>Tanggal</th>
                            <th>PIC</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($riwayat_dpb->get() as $row)
                        @php
                        $pic = DB::table('users')->where('id', $row->pic)->first();
                        @endphp
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$row->keterangan_perubahan}}</td>
                            <td>{{$row->tanggal_perubahan}}</td>
                            <td>{{$pic->first_name . ' ' . $pic->last_name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            @endif
        </div>


        <div class="card card-body mt-5">
            <div class="row">
                <div class="col-6">
                    <h6 class="text-primary font-weight-bold">Authority</h6>
                </div>
            </div>
            <hr>

            @php
            @endphp

            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Diinput oleh</label>
                <label class="col-9 col-form-label">{{$dpb->pic_dpb . ' pada waktu ' . $dpb->created_at}}</label>
            </div>

            @if($riwayat_dpb->count() > 0)
            @php
            $last_update_dpb = collect(DB::select("SELECT *
            FROM data_perubahan_dpb
            JOIN users ON data_perubahan_dpb.pic = users.id
            WHERE id_dpb = $id ORDER BY id DESC LIMIT 1"))->first();
            @endphp
            <div class="form-group row">
                <label class="col-3 col-form-label font-weight-bold">Update terakhir oleh</label>
                <label class="col-9 col-form-label">{{$last_update_dpb->first_name . ' ' . $last_update_dpb->last_name . ' pada waktu ' . $last_update_dpb->tanggal_perubahan}}</label>
            </div>
            @endif

        </div>



        <div class="form-group row mt-5">
            <div class="col-6">
                <a class="btn btn-danger font-weight-bold" href="javascript:void(0)" onclick="delete_dpb('{{$id}}', '{{$dpb->nama_pekerjaan}}')"><i class="fa fa-trash"></i> Delete DPB</a>
            </div>
            <div class="text-right col-6">
                <a class="btn btn-secondary font-weight-bold" href="{{url('dpb/' . Session::get('id_users'))}}">Kembali</a>
                <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
            </div>
        </div>

    </form>
</div>


@include('dpb/objek_pekerjaan/modal_add')
@include('dpb/objek_pekerjaan/modal_edit')
@include('dpb/tenaga_ahli/modal_add')
@include('dpb/tenaga_ahli/modal_edit')
@include('dpb/termin/modal_add')


@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>


<script>
    $(document).ready(function() {
        $('.example').DataTable();
    });
</script>


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

    $(function() {
        $(":radio.is_objek_pekerjaan_alias").click(function() {
            if ($(this).val() == 1) {
                $("#display_objek_pekerjaan_alias").show();
                $("#objek_pekerjaan_alias").prop('required', true);
            } else {
                $("#display_objek_pekerjaan_alias").hide();
                $("#objek_pekerjaan_alias").removeAttr('required');
            }
        })
    });
</script>


<script>
    $(document).ready(function() {
        $("#id_pemberi_kerja").append($("<option selected='selected'></option>").val('{{$dpb->id_pemberi_kerja}}')
            .text('{{$dpb->nama_pemberi_kerja}}')).trigger('change');

        $("#id_ppk").append($("<option selected='selected'></option>").val('{{$dpb->id_ppk}}').html(
            '{{$dpb->nama_ppk}}')).trigger('change');
        $("#id_pptk").append($("<option selected='selected'></option>").val('{{$dpb->id_pptk}}').html(
            '{{$dpb->nama_pptk}}')).trigger('change');
        $("#id_kpa").append($("<option selected='selected'></option>").val('{{$dpb->id_kpa}}').html(
            '{{$dpb->nama_kpa}}')).trigger('change');
        $("#id_pa").append($("<option selected='selected'></option>").val('{{$dpb->id_pa}}').html(
            '{{$dpb->nama_pa}}')).trigger('change');

    });

    $('#id_pemberi_kerja').select2({
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
            format: "YYYY-MM-DD",
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

@include('dpb/termin/javascript')
@include('dpb/tenaga_ahli/javascript')
@include('dpb/objek_pekerjaan/javascript')


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
                    'Berhasil memproses data.',
                    'success'
                );
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(response) {
                // handle error response
                alert('Error memproses data. Hanya ada 1 tenaga ahli lead dalam 1 proyek.');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            contentType: false,
            processData: false
        });
    })
</script>



<script>
    function delete_dpb(id1, id2) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: "Anda akan menghapus DPB <b>" + id2 + "</b> ?",
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
                    url: "{{url('dpb/delete-dpb')}}/" + id1,
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            Swal.fire('Informasi', 'Berhasil menghapus data', 'success');
                            setTimeout(function() {
                                location.href = "{{url('dpb/' . Session::get('id_users'))}}";
                            }, 1500);
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