<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PengalamanPerusahaan extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $table = 'view_pengalaman_perusahaan';

    protected $primaryKey = 'id_data_pengalaman';

    public static function semua()
    {
        $query = "
        SELECT NULL AS
            id_data_pengalaman,
            '0' AS input_manual,
            IFNULL(
                dpb.tahun_anggaran,
                IFNULL((
                    SELECT
                        rup.tahun_anggaran
                    FROM
                        (
                            daftar_informasi_lelang dil
                        JOIN rencana_umum_pengadaan rup ON ( dil.id_rup = rup.id_rup ))
                    WHERE
                        dil.id_dil = dpb.id_dil
                        ),(
                    SELECT
                        import_rencana_umum_pengadaan.tahun_anggaran
                    FROM
                        (
                            daftar_informasi_lelang
                        JOIN import_rencana_umum_pengadaan ON ( daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                    ))) AS tahun,
            IFNULL(
                dpb.nama_pekerjaan,
                IFNULL((
                    SELECT
                        rencana_umum_pengadaan.nama_pekerjaan
                    FROM
                        (
                            rencana_umum_pengadaan
                        JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                        ),(
                    SELECT
                        import_rencana_umum_pengadaan.nama_pekerjaan
                    FROM
                        (
                            import_rencana_umum_pengadaan
                        JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                    ))) AS nama_pekerjaan,
            dpb.id_dil AS id_dil,



						IFNULL(

        IF((SELECT id_jenis_pekerjaan FROM jenis_pekerjaan WHERE id_jenis_pekerjaan = dpb.id_jenis_pekerjaan) = 'Lelang',

        (
        SELECT metode_pengadaan.nama_metode_pengadaan FROM rencana_umum_pengadaan
        JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        JOIN metode_pengadaan ON metode_pengadaan.id_metode_pengadaan = rencana_umum_pengadaan.id_pemilihan_penyedia
        JOIN daftar_proyek_berjalan ON daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil
        WHERE daftar_proyek_berjalan.id_dpb = dpb.id_dpb
        ),

        (SELECT id_jenis_pekerjaan FROM jenis_pekerjaan WHERE id_jenis_pekerjaan = dpb.id_jenis_pekerjaan)),


        (
        SELECT import_rencana_umum_pengadaan.nama_metode_pengadaan FROM import_rencana_umum_pengadaan
        JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup
        JOIN daftar_proyek_berjalan ON daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil
        WHERE daftar_proyek_berjalan.id_dpb = dpb.id_dpb
        )) AS id_jenis_pekerjaan_dpb,



            IFNULL(
                dpb.id_bidang_pekerjaan_dpb,(
                SELECT
                    rup.id_bidang_pekerjaan
                FROM
                    (
                        daftar_informasi_lelang dil
                    JOIN rencana_umum_pengadaan rup ON ( dil.id_rup = rup.id_rup ))
                WHERE
                    dil.id_dil = dpb.id_dil
                )) AS id_bidang_pekerjaan,
            IFNULL((
                SELECT
                    bidang_pekerjaan.nama_bidang_pekerjaan
                FROM
                    bidang_pekerjaan
                WHERE
                    dpb.id_bidang_pekerjaan_dpb = bidang_pekerjaan.id_bidang_pekerjaan
                    ),
                IFNULL((
                    SELECT
                        bidang_pekerjaan.nama_bidang_pekerjaan
                    FROM
                        ((
                                bidang_pekerjaan
                                JOIN rencana_umum_pengadaan ON ( rencana_umum_pengadaan.id_bidang_pekerjaan = bidang_pekerjaan.id_bidang_pekerjaan ))
                        JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                        ),(
                    SELECT
                        import_rencana_umum_pengadaan.nama_bidang_pekerjaan
                    FROM
                        (
                            import_rencana_umum_pengadaan
                        JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                    ))) AS bidang_sub_bidang,
            dpb.is_objek_pekerjaan_alias AS lokasi_alias,
            NULL AS id_lokasi,
        IF
            (
                dpb.is_objek_pekerjaan_alias = '1',
                dpb.objek_pekerjaan_alias,
            IF
                ((
                    SELECT
                        lokasi_alias
                    FROM
                        daftar_proyek_berjalan
                    WHERE
                        daftar_proyek_berjalan.id_dpb = dpb.id_dpb
                        ) = '1',(
                    SELECT
                        daftar_proyek_berjalan.objek_pekerjaan_alias
                    FROM
                        daftar_proyek_berjalan
                    WHERE
                        daftar_proyek_berjalan.id_dpb = dpb.id_dpb
                        ),(
                    SELECT
                        daftar_proyek_berjalan.lokasi_pekerjaan
                    FROM
                        daftar_proyek_berjalan
                    WHERE
                        daftar_proyek_berjalan.id_dpb = dpb.id_dpb
                    ))) AS lokasi,
            IFNULL((
                SELECT
                    branch_agency.branch_name
                FROM
                    branch_agency
                WHERE
                    branch_agency.id_branch_agency = dpb.id_pemberi_kerja
                    ),
                IFNULL((
                    SELECT
                        branch_agency.branch_name
                    FROM
                        (((
                                    branch_agency
                                    JOIN rencana_umum_pengadaan ON ( rencana_umum_pengadaan.organization = branch_agency.id_branch_agency ))
                                JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup ))
                        JOIN daftar_proyek_berjalan ON ( daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                        ),(
                    SELECT
                        import_rencana_umum_pengadaan.nama_organisasi
                    FROM
                        (
                            import_rencana_umum_pengadaan
                        JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                    ))) AS pengguna_jasa,
            IFNULL((
                SELECT
                    branch_agency.address
                FROM
                    branch_agency
                WHERE
                    branch_agency.id_branch_agency = dpb.id_pemberi_kerja
                    ),
                IFNULL((
                    SELECT
                        branch_agency.address
                    FROM
                        (((
                                    branch_agency
                                    JOIN rencana_umum_pengadaan ON ( rencana_umum_pengadaan.organization = branch_agency.id_branch_agency ))
                                JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup ))
                        JOIN daftar_proyek_berjalan ON ( daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                        ),(
                    SELECT
                        import_rencana_umum_pengadaan.alamat_organisasi
                    FROM
                        (
                            import_rencana_umum_pengadaan
                        JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup ))
                    WHERE
                        daftar_informasi_lelang.id_dil = dpb.id_dil
                    ))) AS alamat_pengguna_jasa,
            dpb.nomor_kontrak AS nomor_kontrak,
            IFNULL(
                dpb.nilai_pekerjaan,(
                SELECT
                    hasil_lelang.nilai_kontrak
                FROM
                    (
                        hasil_lelang
                    JOIN daftar_informasi_lelang ON ( daftar_informasi_lelang.id_dil = hasil_lelang.id_dil ))
                WHERE
                    daftar_informasi_lelang.id_dil = dpb.id_dil
                )) AS nilai_kontrak_kerja,
            dpb.jangka_waktu_mulai AS tgl_mulai_kontrak,
            dpb.jangka_waktu_selesai AS tgl_selesai_kontrak,
            fip.tanggal_bast AS tgl_bast,
            to_days( dpb.jangka_waktu_selesai ) - to_days( dpb.jangka_waktu_mulai ) AS durasi_pekerjaan,
            '1' AS is_dpb
        FROM
            (
                formulir_informasi_pekerjaan fip


                JOIN daftar_proyek_berjalan dpb ON ( dpb.id_dpb = fip.id_dpb ))



        UNION


        SELECT
            data_pengalaman_perusahaan.id_data_pengalaman AS id_data_pengalaman,
            '1' AS input_manual,
            data_pengalaman_perusahaan.tahun_anggaran AS tahun,
            data_pengalaman_perusahaan.nama_pekerjaan AS nama_paket_pekerjaan,
            NULL AS id_dil,

						null AS id_jenis_pekerjaan_dpb,

            data_pengalaman_perusahaan.id_bidang_pekerjaan AS id_bidang_pekerjaan,
            ( SELECT bidang_pekerjaan.nama_bidang_pekerjaan FROM bidang_pekerjaan WHERE bidang_pekerjaan.id_bidang_pekerjaan = data_pengalaman_perusahaan.id_bidang_pekerjaan ) AS bidang_sub_bidang,
            '0' AS lokasi_alias,
        IF
            ( data_pengalaman_perusahaan.is_objek_pekerjaan_alias = '1', NULL, data_pengalaman_perusahaan.id_data_pengalaman ) AS id_lokasi,
        IF
            ( data_pengalaman_perusahaan.is_objek_pekerjaan_alias = '1', data_pengalaman_perusahaan.objek_pekerjaan_alias, data_pengalaman_perusahaan.id_data_pengalaman ) AS lokasi,
            ( SELECT branch_agency.branch_name FROM branch_agency WHERE branch_agency.id_branch_agency = data_pengalaman_perusahaan.organization ) AS pengguna_jasa,
            ( SELECT branch_agency.address FROM branch_agency WHERE branch_agency.id_branch_agency = data_pengalaman_perusahaan.organization ) AS alamat_pengguna_jasa,
            data_pengalaman_perusahaan.nomor_kontrak AS nomor_kontrak,
            data_pengalaman_perusahaan.nilai_pekerjaan AS nilai_kontrak_kerja,
            data_pengalaman_perusahaan.jangka_waktu_mulai AS tgl_mulai_kontrak,
            data_pengalaman_perusahaan.jangka_waktu_selesai AS tgl_selesai_kontrak,
            data_pengalaman_perusahaan.tanggal_bast AS tgl_bast,
            to_days( data_pengalaman_perusahaan.jangka_waktu_selesai ) - to_days( data_pengalaman_perusahaan.jangka_waktu_mulai ) AS durasi_pekerjaan,
            '2' AS is_dpb
        FROM
            data_pengalaman_perusahaan
        ORDER BY
            tahun
        ";

        return DB::select($query);
    }
}
