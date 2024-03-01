<!DOCTYPE html>
<html>

<head>
    <title>SIM KOKEK</title>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'
        integrity='sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z' crossorigin='anonymous'>
</head>

<body>

    <table width='100%' border='0' style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
        <tr>
            <td bgcolor='#66CCFF'>
                <h3 align='center' style="padding:1em;"><b>SIM PT KOKEK</b></h3>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <p>Dear All,</p>
                <p>Terlampir link adalah Dokumen Kualifikasi Panitia terkait Lelang dengan Informasi sbb:</p>


                <table width='100%' border='0' style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
                    <tr>
                        <td width='13%'>Nama Pekerjaan</td>
                        <td width='2%'>:</td>
                        <td width='80%'>{{$dil->nama_pekerjaan}}</td>
                    </tr>
                    <tr>
                        <td>Satuan Kerja</td>
                        <td>:</td>
                        <td>{{$dil->pemberi_kerja}}</td>
                    </tr>
                    <tr>
                        <td>Nilai HPS</td>
                        <td>:</td>
                        <td>Rp. {{number_format($dil->nilai_hps,0,",",".")}}</td>
                    </tr>
                    <tr>
                        <td>Metode Evaluasi</td>
                        <td>:</td>
                        <td>{{$dil->metode_kualifikasi . ' ' . $dil->metode_dokumen . ' - ' . $dil->metode_evaluasi}}</td>
                    </tr>
                    <tr>
                        <td>Jadwal Aanwizing</td>
                        <td>:</td>
                        <td>
                            @php
                            $jadwal_aanwizing = DB::table('tahap_lelang')->where('id_dil', $dil->id_dil)->where('id_data_tahapan_lelang', 4)->first();

                            $tahun_start = date('Y', strtotime($jadwal_aanwizing->waktu_mulai_tahap_lelang));
                            $tahun_end = date('Y', strtotime($jadwal_aanwizing->waktu_sampai_tahap_lelang));
                            $bulan_start = date('m', strtotime($jadwal_aanwizing->waktu_mulai_tahap_lelang));
                            $bulan_end = date('m', strtotime($jadwal_aanwizing->waktu_sampai_tahap_lelang));
                            $tanggal_start = date('d', strtotime($jadwal_aanwizing->waktu_mulai_tahap_lelang));
                            $tanggal_end = date('d', strtotime($jadwal_aanwizing->waktu_sampai_tahap_lelang));

                            $time_start = date('h:i', strtotime($jadwal_aanwizing->waktu_mulai_tahap_lelang));
                            $time_end = date('h:i', strtotime($jadwal_aanwizing->waktu_sampai_tahap_lelang));

                            #cak tahun
                            if($tahun_start == $tahun_end){
                                $tahun = $tahun_start;

                                #cek bulan
                                if($bulan_start == $bulan_end){
                                    $bulan = $bulan_start = date('M', strtotime($jadwal_aanwizing->waktu_mulai_tahap_lelang));

                                    #cek tanggal
                                    if($tanggal_start == $tanggal_end){
                                        $date = $tanggal_start . ' ' . $bulan . ' ' . $tahun;
                                    } else {
                                        $date = $tanggal_start . ' - ' . $tanggal_end . ' ' . $bulan . ' ' . $tahun;
                                    }

                                } else {
                                    
                                    $date = date('d M', strtotime($jadwal_aanwizing->waktu_mulai_tahap_lelang)) . ' s/d ' . date('d M', strtotime($jadwal_aanwizing->waktu_sampai_tahap_lelang)) . ' ' .  $tahun;
                                }
                            } else {
                                
                                $date = date('d M Y', strtotime($jadwal_aanwizing->waktu_mulai_tahap_lelang)) . ' s/d ' . date('d M Y', strtotime($jadwal_aanwizing->waktu_sampai_tahap_lelang));
                            }
                            @endphp

                            <b>{{$date . ', Pukul : ' . $time_start . ' - ' . $time_end . ' WIB'}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Kontrak</td>
                        <td>:</td>
                        <td>{{$dil->jenis_kontrak}}</td>
                    </tr>
                    <tr>
                        <td>Bobot Teknis</td>
                        <td>:</td>
                        <td>{{$dil->bobot_teknis}}</td>
                    </tr>
                    <tr>
                        <td>Bobot Biaya</td>
                        <td>:</td>
                        <td>{{$dil->bobot_biaya}}</td>
                    </tr>
                    <tr>
                        <td>Nilai Ambang Batas Evaluasi Teknis</td>
                        <td>:</td>
                        <td>{{$dil->nilai_batas_evaluasi}}</td>
                    </tr>

                    <tr>
                        <td>PIC Lelang</td>
                        <td>:</td>
                        <td>{{$dil->nama_pic_dil}}</td>
                    </tr>

                    <tr>
                        <td colspan="2"><br>{!! $dil->uraian_aanwizing !!}</td>
                    </tr>
                </table>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td>
                @php
                $users = DB::table('users')->where('id', Session::get('id_users'))->first();
                @endphp
                <b>Regards,
                    <br><br>
                    {{$users->first_name . ' ' . $users->last_name}}
                </b>
            </td>
        </tr>
        <tr>
            <td>
                <span style="font-family: Arial, Helvetica, sans-serif; font-size:10px; color:red;">
                    <br>
                    <br>
                    ** Email ini dikirim otomatis oleh sistem, tidak diperkenankan membalas email ini. Terima Kasih.
                </span>
            </td>
        </tr>
    </table>
</body>

</html>