<!DOCTYPE html>
<html>

<head>
    <title>SIM KOKEK</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    @php
    if($dpb->jumlah_publish != ''){
        $header = 'Diinformasikan kepada pengguna, telah dilakukan perubahan <strong>Daftar Proyek Berjalan (DPB)</strong>
        dengan detail singkat sebagai berikut :';
        $footer = 'Untuk detail selengkapnya, anda bisa membuka SIM PT KOKEK dan menyesuaikan perubahan sesuai dengan divisi
        kerjanya masing-masing.';
    } else {

        $header = 'Diinformasikan kepada pengguna, telah ditambahkan <strong>Daftar Proyek Berjalan (DPB)</strong> dengan
        detail singkat sebagai berikut :';
        $footer = 'Untuk selanjutnya, anda bisa cek dan memproses detail DPB di SIM PT KOKEK dan melakukan sesuai dengan
        divisi kerjanya.';
    }

    $riwayat = DB::table('data_perubahan_dpb')->where('id_dpb', $dpb->id_dpb);
    @endphp

    <table width="100%" border="0" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
        <tr>
            <td bgcolor="#66CCFF">
                <h3 align="center" style="padding:1em;"><strong>SIM PT KOKEK </strong></h3>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <p>Kepada pengguna SIM PT KOKEK,</p>
                <p>{!! $header !!}</p>

                <table width="100%" border="0" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
                    <tr>
                        <td width="18%"><b>Kode DPB</b></td>
                        <td width="2%"><b>:</b></td>
                        <td width="82%">{{$dpb->kode_dpb}}</td>
                    </tr>
                    <tr>
                        <td><b>Nama Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{{$dpb->nama_pekerjaan}}</td>
                    </tr>
                    <tr>
                        <td><b>Jenis Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{{$dpb->jenis_pekerjaan_dpb}}</td>
                    </tr>
                    <tr>
                        <td><b>Bidang Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{{$dpb->nama_bidang_pekerjaan}}</td>
                    </tr>
                    <tr>
                        <td><b>Durasi Pekerjaan</b></th>
                        <td><b>:</b></th>
                        <td>{{$dpb->durasi_kontrak_pekerjaan}}</td>
                    </tr>
                    <tr>
                        <td><b>Pemberi Kerja</b></th>
                        <td><b>:</b></th>
                        <td>{{$dpb->nama_pemberi_kerja}}</td>
                    </tr>
                    <tr>
                        <td><b>PIC Marketing</b></th>
                        <td><b>:</b></th>
                        <td>{{$dpb->pic_dpb}}</td>
                    </tr>

                    @if($riwayat->count() > 0)
                    <tr>
                        <td><b>Riwayat Perubahan DPB</b></th>
                        <td><b>:</b></th>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table width="100%" border="1"
                                style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
                                <tr>
                                    <th width="4%">No</th>
                                    <th>Keterangan Perubahan</th>
                                    <th>Tanggal</th>
                                </tr>

                                @php
                                $no = 1;
                                @endphp
                                @foreach($riwayat->get() as $row)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$row->keterangan_perubahan}}</td>
                                    <td>{{$row->tanggal_perubahan}}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    @else 
                    <tr>
                        <td><b>Riwayat Perubahan DPB</b></th>
                        <td><b>:</b></th>
                        <td><i style="color:grey;">Tidak ada perubahan.</i></td>
                    </tr>
                    @endif
                </table>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td>{!! $footer !!}</td>
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