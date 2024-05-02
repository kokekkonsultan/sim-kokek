<!DOCTYPE html>
<html>

<head>
    <title>SIM KOKEK</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>

    <table width="100%" border="1" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
        <tr>
            <td bgcolor="#1c4585">
                <h2 align="center" style="color:#ff6600;"><b>SIM PT KOKEK</b></h2>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <p>Kepada pengguna SIM PT KOKEK,</p>
                <p>Diinformasikan kepada pengguna, telah ditambahkan <b>Formulir Informasi Pekerjaan (FIP)</b> dengan detail singkat sebagai berikut:</p>

                <table width="100%" border="0" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
                    <tr>
                        <td width="18%"><b>Kode Pekerjaan</b></td>
                        <td width="2%"><b>:</b></td>
                        <td width="82%">{!! $fip->kode !!}</td>
                    </tr>
                    <tr>
                        <td><b>Nama Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{!! $fip->nama_pekerjaan !!}</td>
                    </tr>
                    <tr>
                        <td><b>Jenis Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{!! $fip->jenis_pekerjaan !!}</td>
                    </tr>
                    <tr>
                        <td><b>Bidang Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{!! $fip->nama_bidang_pekerjaan !!}</td>
                    </tr>
                    <tr>
                        <td><b>Durasi Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{!! $fip->durasi_kontrak_pekerjaan !!}</td>
                    </tr>
                    <tr>
                        <td><b>Pemberi Kerja</b></th>
                        <td><b>:</b></th>
                        <td>{!! $fip->pemberi_kerja !!}</td>
                    </tr>
                    <tr>
                        <td><b>Alamat</b></th>
                        <td><b>:</b></th>
                        <td>{!! $fip->alamat_pemberi_kerja !!}</td>
                    </tr>
                    <tr>
                        <td><b>PIC Marketing</b></th>
                        <td><b>:</b></th>
                        <td>{!! $fip->pic_marketing !!}</td>
                    </tr>

                    
                </table>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td>Dimohon untuk bagian terkait (<strong>General Manager</strong> dan <strong>Direktur Utama</strong>) untuk meninjau dan mengisi catatan FIP dan memberi <b>Approve</b> melalui SIM PT KOKEK agar segera di proses oleh bagian <strong>Administrasi Proyek.</td>
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