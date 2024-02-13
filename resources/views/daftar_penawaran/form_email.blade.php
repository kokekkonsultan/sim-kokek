<!DOCTYPE html>
<html>

<head>
    <title>SIM KOKEK</title>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' integrity='sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z' crossorigin='anonymous'>
</head>

<body>

    <table width='100%' border='0' style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
        <tr>
            <td bgcolor='#66CCFF'>
                <h3 align='center' style="padding:1em;"><strong>SIM PT KOKEK </strong></h3>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <p>Kepada pengguna SIM PT KOKEK,</p>
                <p>Diinformasikan kepada pengguna, telah ditambahkan hasil <strong>DAFTAR INFORMASI LELANG
                        (DIL)</strong> dengan detail singkat sebagai berikut:</p>
                <table width='100%' border='1' style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
                    <tr>
                        <td width='18%'><strong>Nama Pekerjaan </strong></td>
                        <td width='82%'>{{$dil->nama_pekerjaan}}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Pemberi Kerja </strong></td>
                        <td>{{$dil->pemberi_kerja}}</td>
                    </tr>
                    <tr>
                        <td><strong>Metode </strong></td>
                        <td><strong>Metode Pengadaan</strong> : {{$dil->metode_pengadaan}}<br />
                            <strong>Metode Kualifikasi</strong> : {{$dil->metode_kualifikasi}}<br />
                            <strong>Metode Dokumen</strong> : {{$dil->metode_dokumen}}<br />
                            <strong>Metode Evaluasi</strong> : {{$dil->metode_evaluasi}}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Nilai Pagu </strong></td>
                        <td>Rp. {{number_format($dil->nilai_pekerjaan,0,",",".")}}</td>
                    </tr>
                    <tr>
                        <td><strong>Nilai HPS </strong></td>
                        <td>Rp. {{number_format($dil->nilai_hps,0,",",".")}}</td>
                    </tr>
                    <tr>
                        <td><strong>PIC</strong></td>
                        <td>{{$dil->nama_pic_dil}}</td>
                    </tr>
                    <tr>
                        <td><strong>Hasil Lelang </strong></td>
                        <td>{!! $status !!}</td>
                    </tr>
                </table>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td><span style="font-family: Arial, Helvetica, sans-serif; font-size:10px;">Email ini dikirim otomatis oleh sistem, tidak
                    diperkenankan membalas email ini. Terima Kasih </span></td>
        </tr>
    </table>
</body>

</html>