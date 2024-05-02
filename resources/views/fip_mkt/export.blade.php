<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export FIP Periode {{$mulai == $sampai ? $mulai : $mulai . ' - ' . $sampai}}</title>
    <style>
    table {
        border-collapse: collapse;
        font-family: sans-serif;
        font-size: .8rem;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        font-size: 12px;
    }
    </style>
</head>

<body>

    <div class="table-responsive" style="overflow-x:auto;">
        <table class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color: yellow; text-align:center; ">
                    <td colspan="16" style="font-size: 20px; font-weight:bold;">
                        FORMULIR INFORMASI PEKERJAAN PERIODE {{$mulai == $sampai ? $mulai : $mulai . ' - ' . $sampai}}
                    </td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <th>#</th>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Pemberi Kerja</th>
                    <th>Nama Pekerjaan</th>
                    <th>Sub Bidang Pekerjaan</th>
                    <th>Durasi Pekerjaan</th>
                    <th>PIC Marketing</th>
                    <th>PIC Adpro</th>
                    <th>PIC Konsultan</th>
                    <th>Tanggal BAST</th>
                    <th>Perubahan Terakhir</th>
                </tr>
            </thead>
            <tbody>
                @if($fip->count() > 0)
                @php
                $no = 1;
                @endphp
                @foreach($fip->get() as $row)
                <tr>
                    <td align="center">{{$no++}}</td>
                    <td>{{$row->kode}}</td>
                    <td>{{$row->jenis_pekerjaan}}</td>
                    <td>{{$row->pemberi_kerja}}</td>
                    <td>{{$row->nama_pekerjaan}}</td>
                    <td>{{$row->nama_bidang_pekerjaan}}</td>
                    <td>{{$row->durasi_pekerjaan}}</td>
                    <td>{{$row->pic_marketing}}</td>
                    <td>{{$row->pic_adpro}}</td>
                    <td>{{$row->pic_konsultan}}</td>
                    <td>{{$row->tgl_bast}}</td>
                    <td>{{date('d/m/Y H:i:s', strtotime($row->tgl_perubahan_terakhir))}}</td>

                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="16" align="center"><i style="color:grey;">Tidak ada data pada periode tersebut.</i>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>