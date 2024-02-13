<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rup extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $table = 'view_rencana_umum_pengadaan';



	
//     public static function semua()
//     {
//         $query = "
//         SELECT
// 	irup.id_rup AS id_rup,
// 	irup.nama_pekerjaan AS nama_pekerjaan,
// 	irup.pagu AS pagu,
// 	irup.nama_jenis_pengadaan AS nama_jenis_pengadaan,
// 	irup.nama_metode_pengadaan AS nama_metode_pengadaan,
// 	irup.waktu_pemilihan_penyedia AS waktu_pemilihan_penyedia,
// 	CONCAT( irup.nama_organisasi, ' ', irup.nama_instansi ) AS nama_organisasi,
// 	irup.nama_instansi AS klpd,
// 	irup.nama_organisasi AS satuan_kerja,
// 	irup.lokasi_pekerjaan AS lokasi_pekerjaan,
// 	irup.nama_bidang_pekerjaan AS nama_bidang_pekerjaan,
// 	irup.pic AS pic,
// 	irup.is_sirup AS is_sirup,
// 	SUBSTRING(irup.waktu_pemilihan_penyedia, -4) AS tahun_anggaran,
// 	( SELECT IF ( EXISTS ( SELECT id_rup FROM daftar_informasi_lelang WHERE id_rup = irup.id_rup ), 'Ya', 'Tidak' ) ) AS diproses_di_dil,
// 	irup.is_import AS is_import,
// 	irup.keterangan AS keterangan,
// 	irup.is_pekerjaan_prospek AS is_pekerjaan_prospek,
// 	irup.id_sis_rup AS id_sis_rup
// FROM
// 	import_rencana_umum_pengadaan irup UNION
// SELECT
// 	rup.id_rup AS id_rup,
// 	rup.nama_pekerjaan AS nama_pekerjaan,
// 	rup.pagu AS pagu,
// 	( SELECT nama_kategori_lelang FROM kategori_lelang WHERE id_kategori_lelang = rup.id_jenis_pengadaan ) AS nama_jenis_pekerjaan,
// 	( SELECT nama_metode_pengadaan FROM metode_pengadaan WHERE id_metode_pengadaan = rup.id_pemilihan_penyedia ) AS nama_metode_pengadaan,
// 	CONCAT(
// 		(
// 		SELECT
// 		CASE
// 				bulan_waktu_pemilihan
// 				WHEN '0' THEN
// 				'Januari'
// 				WHEN '1' THEN
// 				'Februari'
// 				WHEN '2' THEN
// 				'Maret'
// 				WHEN '3' THEN
// 				'April'
// 				WHEN '4' THEN
// 				'Mei'
// 				WHEN '5' THEN
// 				'Juni'
// 				WHEN '6' THEN
// 				'Juli'
// 				WHEN '7' THEN
// 				'Agustus'
// 				WHEN '8' THEN
// 				'September'
// 				WHEN '9' THEN
// 				'Oktober'
// 				WHEN '10' THEN
// 				'November'
// 				WHEN '11' THEN
// 				'Desember' ELSE bulan_waktu_pemilihan
// 			END
// 			FROM
// 				rencana_umum_pengadaan
// 			WHERE
// 				id_rup = rup.id_rup
// 			),
// 			' ',
// 			rup.tahun_waktu_pemilihan
// 		) AS waktu_pemilihan_penyedia,
// 		( SELECT branch_name FROM branch_agency WHERE id_branch_agency = rup.organization ) AS nama_organisasi,
// 		(SELECT agency_name FROM agency JOIN branch_agency ON branch_agency.id_agency = agency.id_agency WHERE branch_agency.id_branch_agency = rup.organization) AS klpd,
// 		( SELECT branch_name FROM branch_agency WHERE id_branch_agency = rup.organization ) AS satuan_kerja,
// 		rup.lokasi_pekerjaan AS lokasi_pekerjaan,
// 		( SELECT nama_bidang_pekerjaan FROM bidang_pekerjaan WHERE id_bidang_pekerjaan = rup.id_bidang_pekerjaan ) AS nama_bidang_pekerjaan,
// 		( SELECT CONCAT( users.first_name, ' ', users.last_name ) FROM users WHERE id = rup.input_id ) AS pic,
// 		rup.is_sirup AS is_sirup,
// 		rup.tahun_anggaran AS tahun_anggaran,
// 		( SELECT IF ( EXISTS ( SELECT id_rup FROM daftar_informasi_lelang WHERE id_rup = rup.id_rup ), 'Ya', 'Tidak' ) ) AS diproses_di_dil,
// 		rup.is_import AS is_import,
// 		rup.keterangan AS keterangan,
// 		rup.is_pekerjaan_prospek AS is_pekerjaan_prospek,
// 		rup.id_sis_rup AS id_sis_rup
// FROM
// 	rencana_umum_pengadaan rup
//         ";

//         return DB::select($query);
//     }
}
