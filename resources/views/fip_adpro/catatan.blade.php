@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@php
$a = 1;
$b = 1;
$c = 1;
$d = 1;
$e = 1;
$f = 1;
@endphp

<div class="container-fluid">


    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF; padding: 1em;">
        <h3 class="text-primary font-weight-bolder">{!! strtoupper('Beri Catatan FIP') !!}</h3>
        <b>Silahkan review data FIP terlebih dahulu atau  <a href="#catatan">langsung beri catatan</a>.</b>
    </div>
    

    <div class="card card-body">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary">DETAIL PEKERJAAN</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-secondary font-weight-bold" href="{{url('fip-adpro/' . Session::get('id_users'))}}"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <hr>
        <table class="" border="0" width="100%" cellpadding="7">
            <tr>
                <th width="22%">Nama Pekerjaan</th>
                <th width="3%">:</th>
                <td>{{$fip->nama_pekerjaan}}</td>
            </tr>
            <tr>
                <th>Durasi Pekerjaan</th>
                <th>:</th>
                <td>{{$fip->durasi_kontrak_pekerjaan}}</td>
            </tr>
            <tr>
                <th>Pemberi Kerja</th>
                <th>:</th>
                <td>{{$fip->pemberi_kerja}}</td>
            </tr>
            <tr>
                <th>Alamat Pemberi Kerja</th>
                <th>:</th>
                <td>{!! str_replace(['<p>', '</p>'], '',
                    $fip->alamat_pemberi_kerja) !!}</td>
            </tr>
            <tr>
                <th>Contact Person</th>
                <th>:</th>
                <td>
                    @php
                    if($fip->id_ppk != 0){
                    $cp = '<b>' . $fip->nama_ppk . '</b> (' . implode(", ", unserialize($fip->phone_ppk)) . ') /
                    PPK';
                    } elseif($fip->id_pptk != 0){
                    $cp = '<b>' . $fip->nama_pptk . '</b> (' . implode(", ", unserialize($fip->phone_pptk)) . ') /
                    PPTK';
                    } elseif($fip->id_kpa != 0){
                    $cp = '<b>' . $fip->nama_kpa . '</b> (' . implode(", ", unserialize($fip->phone_kpa)) . ') /
                    KPA';
                    } elseif($fip->id_pa != 0){
                    $cp = '<b>' . $fip->nama_pa . '</b> (' . implode(", ", unserialize($fip->phone_pa)) . ') / PA';
                    } else {
                    $cp = '';
                    }

                    echo $cp;
                    @endphp
                </td>
            </tr>
            <tr>
                <th>Objek Pekerjaan</th>
                <th>:</th>
                <td>
                    @php
                    $ceks = DB::table('daftar_proyek_berjalan')->where('id_dpb', $fip->id_dpb)->first();
                    if ($ceks->is_objek_pekerjaan_alias == 1) {
                    $lokasi = $ceks->objek_pekerjaan_alias;
                    } else {
                    $g_lok = DB::table('objek_pekerjaan')->where('id_dpb', $fip->id_dpb);
                    if ($g_lok->count() > 0) {
                    foreach ($g_lok->get() as $val) {
                    $arr_lokasi[] = '<li>' . DB::table('branch_agency')->where('id_branch_agency',
                        $val->organization)->first()->branch_name . '</li>';
                    }
                    $lokasi = '<ol>' . implode("", $arr_lokasi) . '</ol>';

                    } else {
                    $lokasi = '-';
                    }
                    }
                    echo $lokasi;
                    @endphp
                </td>
            </tr>
            <tr>
                <th>Ruang Lingkup Pekerjaan</th>
                <th>:</th>
                <td>
                    @php
                    $rl = $fip->ruang_lingkup_pekerjaan_seluruh == 1 ? 'Seluruh' : 'Sebagian';
                    $srl = $fip->sebutkan_ruang_lingkup != '' ? '<br>
                    <div class="mt-1"><b>Sebutkan :</b> ' . $fip->sebutkan_ruang_lingkup . '</div>' : '';
                    @endphp

                    {!! $rl . $srl !!}
                </td>
            </tr>
            <tr>
                <th>Jumlah Termin Pembayaran</th>
                <th>:</th>
                <td>
                    {{DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $fip->id_dpb)->count()}}
                    Termin
                </td>
            </tr>
            <tr>
                <th>Tenaga Ahli (Lead)</th>
                <th>:</th>
                <td>
                    @php
                    $tg = collect(DB::select("SELECT *,
                    (SELECT nama_lengkap FROM tenaga_ahli JOIN person_personal_data ON tenaga_ahli.id_person =
                    person_personal_data.id_person WHERE tenaga_ahli.id_tenaga_ahli =
                    tenaga_ahli_proyek_berjalan.id_tenaga_ahli) AS nama_lengkap
                    FROM tenaga_ahli_proyek_berjalan
                    WHERE is_lead = 1 && id_dpb = $fip->id_dpb"));

                    echo $tg->count() > 0 ? $tg->first()->nama_lengkap : ''
                    @endphp
                </td>
            </tr>
        </table>
    </div>

    <div class="card card-body mt-5">
        <h6 class="text-primary">BIAYA PERSONIL</h6>
        <hr>


        <table class="table table-bordered table-hover example">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
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
                </tr>
            </thead>
            <tbody>


                @foreach(DB::table('fip_biaya')->where(['id_fip' => $fip->id_fip, 'id_jenis_fip_biaya' => 1])->get() as $value)
                <tr>
                    <td class="text-center">{{$a++}}</td>
                    <td>{{$value->uraian}}</td>
                    <td class="text-center">{{$value->volume1}}</td>
                    <td>{{$value->satuan1}}</td>
                    <td class="text-center">{{$value->volume2}}</td>
                    <td>{{$value->satuan2}}</td>
                    <td class="text-center">{{$value->volume3}}</td>
                    <td>{{$value->satuan3}}</td>
                    <td class="text-right">
                        {{($value->harga_satuan)? number_format($value->harga_satuan,0,',','.') : '-'}}</td>
                    <td class="text-right">
                        {{($value->jumlah)? number_format($value->jumlah,0,',','.') : '-'}}</td>
                    <td>{{$value->keterangan}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="card card-body mt-5">
        <h6 class="text-primary">BIAYA NON PERSONIL</h6>
        <hr>

        <table class="table table-bordered table-hover example" width="100%">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
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
                </tr>
            </thead>

            <tbody>
                @foreach(DB::table('fip_biaya')->where(['id_fip' => $fip->id_fip, 'id_jenis_fip_biaya' => 2])->get() as $value)
                <tr>
                    <td class="text-center">{{$b++}}</td>
                    <td>{{$value->uraian}}</td>
                    <td class="text-center">{{$value->volume1}}</td>
                    <td>{{$value->satuan1}}</td>
                    <td class="text-center">{{$value->volume2}}</td>
                    <td>{{$value->satuan2}}</td>
                    <td class="text-center">{{$value->volume3}}</td>
                    <td>{{$value->satuan3}}</td>
                    <td class="text-right">
                        {{($value->harga_satuan)? number_format($value->harga_satuan,0,',','.') : '-'}}</td>
                    <td class="text-right">
                        {{($value->jumlah)? number_format($value->jumlah,0,',','.') : '-'}}</td>
                    <td>{{$value->keterangan}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="card card-body mt-5">
        <h6 class="text-primary">CATATAN DARI MARKETING</h6>
        <hr>

        <table class="table table-bordered table-hover example" width="100%">
            <thead class="bg-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="85%">Catatan</th>
                    <th>Tgl & Paraf</th>
                </tr>
            </thead>

            <tbody>
                @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 1])->get() as $value)
                <tr>
                    <th>{{$c++}}</th>
                    <td>{!! $value->isi_catatan !!}</td>
                    <td class="text-center">{{date('d M Y', strtotime($value->tanggal_catatan))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card card-body mt-5">
        <h6 class="text-primary">CATATAN DARI MANAGER OPERASIONAL</h6>
        <hr>

        <table class="table table-bordered table-hover example" width="100%">
            <thead class="bg-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="85%">Catatan</th>
                    <th>Tgl & Paraf</th>
                </tr>
            </thead>

            <tbody>
            @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 2])->get() as $value)
            <tr>
                <th>{{$d++}}</th>
                <td>{!! $value->isi_catatan !!}</td>
                <td>{{date('d M Y', strtotime($value->tanggal_catatan))}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <div class="card card-body mt-5">
        <h6 class="text-primary">CATATAN DARI DIREKTUR</h6>
        <hr>

        <table class="table table-bordered table-hover example" width="100%">
            <thead class="bg-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="85%">Catatan</th>
                    <th>Tgl & Paraf</th>
                </tr>
            </thead>

            <tbody>
            @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 4])->get() as $value)
            <tr>
                <th>{{$e++}}</th>
                <td>{!! $value->isi_catatan !!}</td>
                <td>{{date('d M Y', strtotime($value->tanggal_catatan))}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <div class="card card-body mt-5" id="catatan">
        <div class="row">
            <div class="col-6">
                <h6 class="text-primary">CATATAN DARI ADMIN PROYEK</h6>
            </div>
            <div class="col-6 text-right">
                <a class="btn btn-primary font-weight-bold btn-sm" data-toggle="modal" data-target="#add_catatan"><i
                        class="fa fa-plus"></i> Tambah Catatan Adpro</a>
            </div>
        </div>
        <hr>

        <table class="table table-bordered table-hover example" width="100%">
            <thead class="bg-light">
                <tr>
                    <th width="5%">No</th>
                    <th width="85%">Catatan</th>
                    <th>Tgl & Paraf</th>
                    <th width="9%"></th>
                </tr>
            </thead>

            <tbody>
            @foreach(DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 3])->get() as $value)
            <tr>
                <th>{{$f++}}</th>
                <td>{!! $value->isi_catatan !!}</td>
                <td>{{date('d M Y', strtotime($value->tanggal_catatan))}}</td>
                <th>
                    <a class="btn btn-light-info btn-icon btn-sm" data-toggle="modal" data-target="#edit_catatan_{{$value->id_catatan_fip}}"> <i class="fa fa-edit"></i></a>
                    <button class="btn btn-light-danger btn-icon btn-sm" href="javascript:void(0)" onclick="delete_catatan('{{$value->id_catatan_fip}}')"><i class="fa fa-trash"></i></button>
                </th>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div class="card card-body mt-5">
        <h6 class="text-primary">TANGGAPAN</h6>
        <hr>

        <table class="table table-hover example" width="100%">
            <thead>
                <tr>
                    <th width="15%"></th>
                    <th></th>
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
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


@include('fip_adpro/modal_add_catatan')
@include('fip_adpro/modal_edit_catatan')


@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif

<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>

<script>
    $(document).ready(function() {
        $('.example').DataTable();
    });
</script>

<script>
    $('#id_marketing').select2({
        placeholder: "Please Select",
        width: '100%'
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



<script>
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
@endsection