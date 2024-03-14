<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export DPB Periode {{$mulai == $sampai ? $mulai : $mulai . ' - ' . $sampai}}</title>
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
						DAFTAR PROYEK BERJALAN PERIODE {{$mulai == $sampai ? $mulai : $mulai . ' - ' . $sampai}}
                    </td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <th>No.</th>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Bidang / Sub Bidang Pekerjaan</th>
					<th>Pemberi Kerja</th>
					<th>Nama Pekerjaan</th>
					<th>Nilai Kontrak (Rp)</th>
					<th>Perubahan Nilai Kontrak (Rp)</th>
					<th>Termin Pembayaran</th>
					<th>Durasi Kontrak Pekerjaan</th>
					<th>Tanggal Terima Kontrak</th>
					<th>Tanggal Terima Surat Referensi</th>
					<th>Tanggal Terima BAST</th>
					<th>PIC</th>
					<th>Perubahan Terakhir</th>
					<th>Keterangan DPB</th>
                </tr>
            </thead>
            <tbody>
				@if($dpb->count() > 0)
				@php
				$no = 1;
				@endphp
				@foreach($dpb->get() as $row)
				<tr>
					<td align="center">{{$no++}}</td>
					<td align="center">{{$row->kode_dpb}}</td>
					<td>{{$row->jenis_pekerjaan_dpb}}</td>
					<td>{{$row->nama_bidang_pekerjaan}}</td>
					<td>{{$row->nama_pemberi_kerja}}</td>
					<td>{{$row->nama_pekerjaan}}</td>
					<td align="right">{{number_format($row->nilai_kontrak, 0, ",", ".")}}</td>
					<td align="right">{{number_format($row->perubahan_nilai_kontrak, 0, ",", ".")}}</td>
					<td align="center">{{$row->jumlah_termin_pembayaran}}</td>
					<td>{{$row->durasi_kontrak_pekerjaan}}</td>
					<td>{{$row->tgl_terima_kontrak}}</td>
					<td>{{$row->tgl_terima_surat_referensi}}</td>
					<td>{{$row->tgl_terima_bast}}</td>
					<td>{{$row->pic_dpb}}</td>
					<td>{{$row->tanggal_perubahan_terakhir}}</td>
					<td>{{$row->keterangan_dpb}}</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="16" align="center"><i style="color:grey;">Tidak ada data pada periode tersebut.</i></td>
				</tr>
				@endif
            </tbody>
        </table>
    </div>
</body>
</html>