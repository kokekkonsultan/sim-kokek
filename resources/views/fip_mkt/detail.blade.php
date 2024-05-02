<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="SIM KOKEK" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title : "KOKEK Consulting" }}</title>
    <link rel="canonical" href="https://www.kokek.com" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://192.168.1.100/assets/vendor/jquery_easing/css/animate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
    body {
        background-color: white;
        font-family: 'Source Sans Pro', sans-serif;
    }

    table {
        font-size: 14px;
    }

    .td-side-1 {
        padding: 5px;
        color: #AB336F;
        background-color: #FFFF99;
        font-weight: bold;
    }

    .td-side-2 {
        padding: 5px;
        background-color: #FFFF99;
        text-align: center;
    }

    .td-side-3 {
        padding: 5px;
        background-color: #FFFF99;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-light" style="background-color: #ABC9E3;">
        <a class="navbar-text font-weight-bold" onclick="window.print()" style="color: #000B51">
            <i class="fa fa-print"></i> FORMULIR INFORMASI PEKERJAAN
        </a>
    </nav>

    <div class="container wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">


        <div class="container mt-5">

            <table class="" border="1" width="100%" style="background-color: #000B51; color: #FFFFFF;" cellpadding="10">
                <tr>
                    <th class="text-center" style="vertical-align: middle; font-size: 25px;">FORMULIR INFORMASI
                        PEKERJAAN</th>
                    <th class="text-center" style="font-size: 20px;">KODE PROYEK<br>{{$fip->kode}}</th>

                    <th style="font-size: 11px;" width="30%">
                        <div class="row mb-1">
                            <div class="col-3">Marketing</div>
                            <div class="col-1 text-right">:</div>
                            <div class="col-7">{{$fip->pic_marketing}}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-3">Adpro</div>
                            <div class="col-1">:</div>
                            <div class="col-7">{{$fip->pic_adpro}}</div>
                        </div>

                        <div class="row">
                            <div class="col-3">Konsultan</div>
                            <div class="col-1">:</div>
                            <div class="col-7">{{$fip->pic_konsultan}}</div>
                        </div>
                    </th>
                </tr>
            </table>

            <div class="text-center mt-3 mb-3" style="background-color: #000B51; color: #FFFFFF;">
                <b>DATA</b>
            </div>

            <table class="" width="100%" cellpadding="7">
                <tr>
                    <th width="22%">Nama Pekerjaan</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">{{$fip->nama_pekerjaan}}</td>
                </tr>
                <tr>
                    <th width="22%">Durasi Pekerjaan</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">{{$fip->durasi_kontrak_pekerjaan}}</td>
                </tr>
                <tr>
                    <th width="22%">Pemberi Kerja</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">{{$fip->pemberi_kerja}}</td>
                </tr>
                <tr>
                    <th width="22%">Alamat Pemberi Kerja</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">{!! str_replace(['<p>', '</p>'], '',
                        $fip->alamat_pemberi_kerja) !!}</td>
                </tr>
                <tr>
                    <th width="22%">Contact Person</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">
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
                    <th width="22%">Objek Pekerjaan</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">
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
                    <th width="22%">Ruang Lingkup Pekerjaan</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">
                        @php
                        $rl = $fip->ruang_lingkup_pekerjaan_seluruh == 1 ? 'Seluruh' : 'Sebagian';
                        $srl = $fip->sebutkan_ruang_lingkup != '' ? '<br>
                        <div class="mt-1"><b>Sebutkan :</b> ' . $fip->sebutkan_ruang_lingkup . '</div>' : '';
                        @endphp

                        {!! $rl . $srl !!}
                    </td>
                </tr>
                <tr>
                    <th width="22%">Jumlah Termin Pembayaran</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">
                        {{DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $fip->id_dpb)->count()}}
                        Termin
                    </td>
                </tr>
                <tr>
                    <th width="22%">Tenaga Ahli</th>
                    <th width="3%">:</th>
                    <td style="border-bottom: 1px solid #DDDDDD;">


                        @php
                        $i = 1;
                        $tapb = DB::table('tenaga_ahli_proyek_berjalan')->where('id_dpb', $fip->id_dpb);
                        @endphp
                        @if($tapb->count() > 0)
                        <table class="mb-2" border="1" width="100%" cellpadding="5" style="font-size: 13px;">
                            <tr style="background-color: #e1e8eb;">
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center">Nama Tenaga Ahli</th>
                                <th class="text-center">Posisi</th>
                            </tr>

                           
                           
                            @foreach($tapb->get() as $value)
                            @php
                            $tenaga_ahli = collect(DB::select("SELECT *,
                            (SELECT nama_lengkap FROM person_personal_data WHERE id_person = tenaga_ahli.id_person) AS nama_lengkap
                            FROM tenaga_ahli
                            WHERE id_tenaga_ahli = $value->id_tenaga_ahli"))->first();
                            @endphp
                            <tr>
                                <td style="color: #AB336F; padding: 5px;" class="text-center">{{$i++}}</td>
                                <td style="padding: 5px;">{{$tenaga_ahli->nama_lengkap}}</td>
                                <td style="padding: 5px;">{{$value->posisi_pekerjaan}}</td>
                            </tr>
                            @endforeach
                        </table>
                        @else
                        <i>Tenaga Ahli belum di inputkan / tidak ada tenaga ahli.</i>
                        @endif


                        <!-- @php
                        $tg = collect(DB::select("SELECT *,
                        (SELECT nama_lengkap FROM tenaga_ahli JOIN person_personal_data ON tenaga_ahli.id_person =
                        person_personal_data.id_person WHERE tenaga_ahli.id_tenaga_ahli =
                        tenaga_ahli_proyek_berjalan.id_tenaga_ahli) AS nama_lengkap
                        FROM tenaga_ahli_proyek_berjalan
                        WHERE is_lead = 1 && id_dpb = $fip->id_dpb"));

                        echo $tg->count() > 0 ? $tg->first()->nama_lengkap : ''
                        @endphp -->
                    </td>
                </tr>
            </table>



            <div class="text-center mt-3 mb-3" style="background-color: #000B51; color: #FFFFFF;">
                <b>BIAYA</b>
            </div>


            <table class="" width="100%" cellpadding="7">
                <tr>
                    <th width="22%">Berita Acara Negosiasi</th>
                    <th width="3%">:</th>
                    <td>
                        @php
                        $id_user = Session::get('id_users');
                        $group = "'admin', 'marketing', 'mo', 'direksi', 'keuangan'";

                        if(collect(DB::select("SELECT *, (SELECT name FROM groups WHERE groups.id = users_groups.group_id) AS group_name
                        FROM users
                        JOIN users_groups ON users.id = users_groups.user_id
                        WHERE user_id = $id_user && (SELECT name FROM groups WHERE groups.id = users_groups.group_id) IN ($group)"))->count() == 0){
                            $ban = '<i class="text-info">Bagian ini sengaja tidak ditampilkan</i>';

                        } else {
                            if($fip->file_berita_acara_negosiasi != ''){
                                $ban = '<a class="btn btn-info btn-sm" href="#"><i class="fa fa-file-pdf"></i> Lihat File</a>';

                            } else {
                                $ban = '<i class="text-danger">Berita acara negosiasi belum diterima atau belum diupload oleh PIC.</i>';
                            }
                        }
                        echo $ban;
                        @endphp

                    </td>
                </tr>
                <tr>
                    <th colspan="3">Biaya Personil</th>
                </tr>
                <tr>
                    <td colspan="3">
                        @php
                        $a = 1;
                        $bp = DB::table('fip_biaya')->where(['id_fip' => $fip->id_fip, 'id_jenis_fip_biaya' => 1]);
                        @endphp
                        @if($bp->count() > 0)
                        <table class="mb-2" border="1" width="100%" cellpadding="5" style="font-size: 13px;">
                            <tr style="background-color: #e1e8eb;">
                                <th class="text-center">No</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center">Vol 1</th>
                                <th class="text-center">Sat 1</th>
                                <th class="text-center">Vol 2</th>
                                <th class="text-center">Sat 2</th>
                                <th class="text-center">Vol 3</th>
                                <th class="text-center">Sat 3</th>
                                <th class="text-center">Harga Satuan (Rp.)</th>
                                <th class="text-center">Jumlah (Rp.)</th>
                                <th class="text-center">Keterangan</th>
                            </tr>
                            @foreach($bp->get() as $value)
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
                        </table>
                        @else
                        <div class="text-center"><i>Biaya personil belum di-inputkan</i></div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Biaya Non Personil</th>
                </tr>
                <tr>
                    <td colspan="3">
                        @php
                        $b = 1;
                        $bnp = DB::table('fip_biaya')->where(['id_fip' => $fip->id_fip, 'id_jenis_fip_biaya' => 2]);
                        @endphp
                        @if($bnp->count() > 0)
                        <table class="mb-2" border="1" width="100%" cellpadding="5" style="font-size: 13px;">
                            <tr style="background-color: #e1e8eb;">
                                <th class="text-center">No</th>
                                <th class="text-center">Uraian</th>
                                <th class="text-center">Vol 1</th>
                                <th class="text-center">Sat 1</th>
                                <th class="text-center">Vol 2</th>
                                <th class="text-center">Sat 2</th>
                                <th class="text-center">Vol 3</th>
                                <th class="text-center">Sat 3</th>
                                <th class="text-center">Harga Satuan (Rp.)</th>
                                <th class="text-center">Jumlah (Rp.)</th>
                                <th class="text-center">Keterangan</th>
                            </tr>

                            @foreach($bnp->get() as $value)
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
                        </table>
                        @else
                        <div class="text-center mb-3"><i>Biaya non personil belum di-inputkan</i></div>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- <div class="text-center mt-3 mb-3" style="background-color: #000B51; color: #FFFFFF;">
                <b>BIAYA</b>
            </div> -->

            <table class="mt-2" border="1" width="100%" cellpadding="7">
                <tr style="background-color: #000B51; color: #FFFFFF;">
                    <th class="text-center" width="85%">Catatan dari Marketing</th>
                    <th class="text-center">Tgl & Paraf</th>
                </tr>
                    @php
                    $cp_mkt = DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 1]);
                    @endphp
                    @if($cp_mkt->count() > 0)
                    @foreach($cp_mkt->get() as $value)
                    <tr>
                        <td>{!! $value->isi_catatan !!}</td>
                        <td class="text-center">{{date('d M Y', strtotime($value->tanggal_catatan))}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="2" class="text-center"><i>Belum ada catatan</i></td>
                    </tr>

                    @endif
            </table>


            <table class="mt-4" border="1" width="100%" cellpadding="7">
                <tr style="background-color: #000B51; color: #FFFFFF;">
                    <th class="text-center" width="85%">Catatan dari General Manager</th>
                    <th class="text-center">Tgl & Paraf</th>
                </tr>
                    @php
                    $cp_mo = DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 2]);
                    @endphp
                    @if($cp_mo->count() > 0)
                    @foreach($cp_mo->get() as $value)
                    <tr>
                        <td>{!! $value->isi_catatan !!}</td>
                        <td class="text-center">{{date('d M Y', strtotime($value->tanggal_catatan))}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="2" class="text-center"><i>Belum ada catatan</i></td>
                    </tr>

                    @endif
            </table>

            <table class="mt-4" border="1" width="100%" cellpadding="7">
                <tr style="background-color: #000B51; color: #FFFFFF;">
                    <th class="text-center" width="85%">Catatan dari Direksi</th>
                    <th class="text-center">Tgl & Paraf</th>
                </tr>
                    @php
                    $cp_direksi = DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 4]);
                    @endphp
                    @if($cp_direksi->count() > 0)
                    @foreach($cp_direksi->get() as $value)
                    <tr>
                        <td>{!! $value->isi_catatan !!}</td>
                        <td class="text-center">{{date('d M Y', strtotime($value->tanggal_catatan))}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="2" class="text-center"><i>Belum ada catatan</i></td>
                    </tr>

                    @endif
            </table>


            <table class="mt-4" border="1" width="100%" cellpadding="7">
                <tr style="background-color: #000B51; color: #FFFFFF;">
                    <th class="text-center">Catatan dari Admin Proyek</th>
                </tr>
                    @php
                    $cp_adpro = DB::table('catatan_fip')->where(['id_fip' => $fip->id_fip, 'jenis_catatan' => 3]);
                    @endphp
                    @if($cp_adpro->count() > 0)
                    @foreach($cp_adpro->get() as $value)
                    <tr>
                        <td>{!! $value->isi_catatan !!}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center"><i>Belum ada catatan</i></td>
                    </tr>

                    @endif
            </table>
        </div>

        <br>
        <br>

    </div>








    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.js"></script>
    <script>
    $(document).ready(function() {
            var wow = new WOW({
                    offset: 50,
                    mobile: false,
                    live: true
                }

            );
            wow.init();
        }

    );
    </script>
</body>

</html>