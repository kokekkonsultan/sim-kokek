<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <style>
    table {
        border-collapse: collapse;
        /* font-family: sans-serif; */
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
        /* font-family: 'Times New Roman', Times, serif; */
    }
    </style>
</head>

<body>



    <div style="overflow-x:auto;">
        <table class="table table-bordered table-hover" cellspacing="0" width="100%">
            <thead>
                
                <tr style="background-color: yellow; text-align:center; ">
                    <td colspan="12" style="font-size: 20px; font-weight:bold;">
                        PROSPEK
                    </td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <th>No.</th>
                    <th>Paket</th>
                    <th>Pagu (Rp)</th>
                    <th>Jenis Pengadaan</th>
                    <th>Produk Dakam Negeri</th>
                    <th>Usaha Kecil/ Koperasi</th>
                    <th>Metode</th>
                    <th>Pemilihan</th>
                    <th>K/L/PD</th>
                    <th>Satuan Kerja</th>
                    <th>Lokasi</th>
                    <th>ID</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1;
        foreach ($prospek as $value){
            echo '<tr>
                <td>'.$no++.'</td>
                <td>'.$value->nama_pekerjaan.'</td>
                <td>'.$value->pagu.'</td>
                <td>'.$value->nama_jenis_pengadaan.'</td>
                <td>'.$value->nama_jenis_produk.'</td>
                <td>'.$value->nama_jenis_usaha.'</td>
                <td>'.$value->nama_metode_pengadaan.'</td>
                <td>'.$value->waktu_pemilihan_penyedia.'</td>
                <td>'.$value->klpd.'</td>
                <td>'.$value->satuan_kerja.'</td>
                <td>'.$value->lokasi_pekerjaan.'</td>
                <td>'.$value->id_sis_rup.'</td>
                </tr>';
        }?>
            </tbody>
        </table>
    </div>
</body>

</html>