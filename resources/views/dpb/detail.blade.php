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

    <style>

    body{
        background-color: white;
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
    <div class="container wow fadeInUp animated shadow" style="visibility: visible; animation-name: fadeInUp;">

        <div class="mt-5 mb-3 text-center">
            <h3 class="font-weight-bold">RINCIAN PROYEK BERJALAN</h3>
        </div>
        <div class="container-fluid mt-5">
            <table width="100%" border="1" style="border-color:#000000; font-size: 13px; border-collapse: collapse;" class="shadow-lg">
                
                <tr>
                    <td colspan="6" class="td-side-1" align="center">PROSES KONTRAK KERJA</td>
                </tr>

                <tr>
                    <td class="td-side-1" width="180px">JENIS PEKERJAAN * </td>
                    <td class="td-side-2">:</td>
                    <th class="td-side-3">{{$data->jenis_pekerjaan_dpb}}</th>


                    <td colspan="2" class="td-side-1" width="100px;">TANGGAL DITERIMA KONTRAK / SPK :</td>
                    <td bgcolor="#FFCC00" style="padding: 5px; color: #002E48; font-weight: bold;"></td>
                </tr>

                <tr>
                    <td class="td-side-1">NAMA PEMBERI KERJA</td>
                    <td class="td-side-2">:</td>
                    <td colspan="4" class="td-side-3">
                        @php
                        $teks = $data->pemberi_kerja_parent;
                        $pecah = explode(" ", $teks);
                        $instansi = $pecah[0] == 'Pemerintah' ? trim(preg_replace("/Pemerintah/", "", $teks)) : $teks;
                        $nama_instansi = $data->nama_kategori_instansi_dari_parent == 'Kementerian' ?  $instansi : '';

                        echo trim($data->nama_pemberi_kerja) . ' ' . $nama_instansi;
                        @endphp
                    </td>
                </tr>

                <tr>
                    <td class="td-side-1">NAMA PEKERJAAN</td>
                    <td class="td-side-2">:</td>
                    <th colspan="4" class="td-side-3">{{ $data->nama_pekerjaan }}</th>
                </tr>


                <tr>
                    <td class="td-side-1">NOMOR KONTRAK</td>
                    <td class="td-side-2">:</td>
                    <td class="td-side-3">{{$data->nomor_kontrak}}</td>


                    <td colspan="3" bgcolor="#FFCC99" style="padding: 5px;">
                        @if($data->id_ppk)
                        <b>NAMA PPK</b> : <b style="color: #FF0000;">{{$ppk->contact_person_name}}</b> ({{implode("; ", unserialize($ppk->phone))}})
                        @endif

                        @if($data->id_pptk)
                        <br><b>NAMA PPTK</b> : <b style="color: #FF0000;">{{$pptk->contact_person_name}}</b> ({{implode("; ", unserialize($pptk->phone))}})
                        @endif

                        @if($data->id_kpa)
                        <br><b>NAMA KPA</b> : <b style="color: #FF0000;">{{$kpa->contact_person_name}}</b> ({{implode("; ", unserialize($kpa->phone))}})
                        @endif

                        @if($data->id_pa)
                        <br><b>NAMA PA</b> : <b style="color: #FF0000;">{{$pa->contact_person_name}}</b> ({{implode("; ", unserialize($pa->phone))}})
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="td-side-1">TANGGAL KONTRAK</td>
                    <td class="td-side-2">:</td>
                    <td colspan="4" class="td-side-3">{{$data->durasi_kontrak_pekerjaan}}</td>
                </tr>

                <tr>
                    <td class="td-side-1">NILAI PEKERJAAN</td>
                    <td class="td-side-2">:</td>
                    <td colspan="4" class="td-side-3">Rp. {{number_format($data->nilai_kontrak, 0, ',', '.')}}</td>
                </tr>

                <tr>
                    <td class="td-side-1">JANGKA WAKTU</td>
                    <td class="td-side-2">:</td>
                    <td colspan="4" class="td-side-3">{{$data->jangka_waktu_mulai}}</td>
                </tr>

                <tr>
                    <td class="td-side-1">JUMLAH TERMIN</td>
                    <td class="td-side-2">:</td>
                    <td colspan="4" class="td-side-3">
                        <table border="1px" width="100%" style="border-color: #DDDDDD; font-size: 13px;">
                            <tr>
                                <th></th>
                                <th style="color: #AB336F; padding: 5px;" class="text-center" width="5%">%</th>
                                <th style="color: #AB336F; padding: 5px;" class="text-center" width="12%">Nominal (Rp)</th>
                                <th style="color: #AB336F; padding: 5px;" class="text-center">Syarat Pembayaran **</th>
                            </tr>

                            @php
                            $no = 1;
                            $termin = DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $id);

                            if(collect(DB::select("SELECT nilai_pekerjaan, nilai_kontrak
                                FROM daftar_proyek_berjalan
                                JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_dil = daftar_proyek_berjalan.id_dil
                                JOIN hasil_lelang ON hasil_lelang.id_dil = daftar_informasi_lelang.id_dil
                                WHERE daftar_proyek_berjalan.id_dpb = $id"))->count() > 0) {
                                    
                                $hsc = $data->perubahan_nilai_pekerjaan != '' ? $data->perubahan_nilai_pekerjaan : $data->nilai_kontrak;
                            } else {
                                $hsc = $data->perubahan_nilai_pekerjaan != '' ? $data->perubahan_nilai_pekerjaan : $data->nilai_pekerjaan;
                            }
                                
                            @endphp
                            @if($termin->count() > 0)
                            @foreach($termin->get() as $row)
                                <tr>
                                    <td style="color: #AB336F; padding: 5px;" class="text-center">{{$no++}}</td>
                                    <td style="padding: 5px;" class="text-center">{{$row->persentase_pembayaran}}</td>
                                    <td style="color: #AB336F; padding: 5px;" class="text-right">{{number_format(($row->persentase_pembayaran / 100) * $hsc, 0, ',', '.')}}</td>
                                    <td style="padding: 5px;">{{$row->syarat_pembayaran}}</td>
                                </tr>
                            @endforeach
                            @endif
                        </table>
                    </td>
                </tr>

                <tr>
                    <td class="td-side-1">PPN</td>
                    <td class="td-side-2">:</td>
                    <td colspan="4" class="td-side-3">
                    @php
                    if ($data->jenis_pajak == 1) {
                        $pjk = "Termasuk PPN";
                    } elseif ($data->jenis_pajak == 2) {
                        $pjk = "Tidak Termasuk PPN";
                    } elseif ($data->jenis_pajak == 3) {
                        $pjk = "Tanpa PPN";
                    } else {
                        $pjk = '';
                    }
                    $persentase_pajak = $data->jenis_pajak == 1 ? '(' . $data->besaran_persentase_pajak . '%)' : '';
                    echo $pjk . ' ' . $persentase_pajak;
                    @endphp
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#CCFFCC" style="padding: 5px;"><b style="color: #008000;">OBYEK PEKERJAAN</b></td>
                    <td bgcolor="#CCFFCC" style="padding: 5px;" align="center">:</td>
                    <td colspan="4" bgcolor="#CCFFCC" style="padding: 5px; color: #AB336F;">
                        {{$data->is_objek_pekerjaan_alias == 1 ? $data->objek_pekerjaan_alias : $data->lokasi_pekerjaan}}
                    </td>
                </tr>

                <tr>
                    <td class="td-side-1">TENAGA AHLI</td>
                    <td class="td-side-2">:</td>
                    <td colspan="4" class="td-side-3">
                        <table border="1px" width="100%" style="border-color: #DDDDDD; font-size: 13px;">
                            
                                <tr>
                                    <th></th>
                                    <th style="color: #AB336F; padding: 5px;" class="text-center">NAMA TENAGA AHLI</th>
                                    <th style="color: #AB336F; padding: 5px;" class="text-center">POSISI</th>
                                </tr>

                                @php
                                $i = 1;
                                @endphp
                                @foreach(DB::table('tenaga_ahli_proyek_berjalan')->where('id_dpb', $id)->get() as $value)
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
                    </td>
                </tr>
            </table>
            <div class="mt-5" style="font-size: 12px; color:red;"><b>Informasi</b>
                <br>
                * : Diketikkan Dengan Pilihan Swakelola / PL / Lelang
                <br>
                ** : Diisi Syarat Jatuh Tempo Termin. Contoh Apabila Pekerjaan Telah Selesai 20%
            </div>
            <br>
        </div>
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