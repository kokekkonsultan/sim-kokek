<?php

namespace App\Http\Controllers;

use App\Models\DpbMarketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OmzetDpb;

class KeuanganOmzetController extends Controller
{
    private $data;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Omzet";

        $tahun = $request->tahun;
        $validasi_keuangan = $request->validasi_keuangan;

        if (strlen($tahun)) {

            if (strlen($validasi_keuangan)) {
                if ($validasi_keuangan == 'Belum Divalidasi') {
                    $this->data['data_omzet'] = collect(OmzetDpb::semua())->where('tahun_dpb', $tahun)->where('is_validasi_keuangan', null);
                } else {
                    $this->data['data_omzet'] = collect(OmzetDpb::semua())->where('tahun_dpb', $tahun)->where('is_validasi_keuangan', $validasi_keuangan);
                }

            } else {
                $this->data['data_omzet'] = collect(OmzetDpb::semua())->where('tahun_dpb', $tahun);
            }

        } else {
            $this->data['data_omzet'] = collect(OmzetDpb::semua())->where('tahun_dpb', date('Y'));
        }

        // dd($this->data['data_omzet']);

        return view('keuangan_omzet.index', $this->data);
    }

    public function validasi(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Validasi Omzet";
        $this->data['id_dpb'] = $request->id_dpb;


        $query = "
        SELECT

        dpb.id_dpb AS id_dpb,
        dpb.id_dil AS id_dil,
        dpb.kode_dpb AS kode_dpb,



        IFNULL(
        dpb.tahun_anggaran,
        IFNULL((SELECT tahun_anggaran FROM rencana_umum_pengadaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil),
        (SELECT tahun_anggaran FROM import_rencana_umum_pengadaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil)
        ))

        AS tahun_dpb,





        IFNULL(

        IF((SELECT nama_jenis_pekerjaan FROM jenis_pekerjaan WHERE id_jenis_pekerjaan = dpb.id_jenis_pekerjaan) = 'Lelang',

        (
        SELECT metode_pengadaan.nama_metode_pengadaan FROM rencana_umum_pengadaan
        JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        JOIN metode_pengadaan ON metode_pengadaan.id_metode_pengadaan = rencana_umum_pengadaan.id_pemilihan_penyedia
        JOIN daftar_proyek_berjalan ON daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil
        WHERE daftar_proyek_berjalan.id_dpb = dpb.id_dpb
        ),

        (SELECT nama_jenis_pekerjaan FROM jenis_pekerjaan WHERE id_jenis_pekerjaan = dpb.id_jenis_pekerjaan)),


        (
        SELECT import_rencana_umum_pengadaan.nama_metode_pengadaan FROM import_rencana_umum_pengadaan
        JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup
        JOIN daftar_proyek_berjalan ON daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil
        WHERE daftar_proyek_berjalan.id_dpb = dpb.id_dpb
        )) AS jenis_pekerjaan_dpb,



        IFNULL(dpb.id_bidang_pekerjaan_dpb,

        IFNULL((SELECT bidang_pekerjaan.id_bidang_pekerjaan FROM bidang_pekerjaan JOIN rencana_umum_pengadaan ON rencana_umum_pengadaan.id_bidang_pekerjaan = bidang_pekerjaan.id_bidang_pekerjaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil),

        null)

        )AS id_bidang_pekerjaan,


        IFNULL((SELECT nama_bidang_pekerjaan FROM bidang_pekerjaan WHERE id_bidang_pekerjaan = dpb.id_bidang_pekerjaan_dpb),

        IFNULL((SELECT nama_bidang_pekerjaan FROM bidang_pekerjaan JOIN rencana_umum_pengadaan ON rencana_umum_pengadaan.id_bidang_pekerjaan = bidang_pekerjaan.id_bidang_pekerjaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil),

        (SELECT nama_bidang_pekerjaan FROM import_rencana_umum_pengadaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil))
        )AS nama_bidang_pekerjaan,

        IFNULL((SELECT branch_name FROM branch_agency WHERE id_branch_agency = dpb.id_pemberi_kerja),
        IFNULL((SELECT branch_name FROM branch_agency JOIN rencana_umum_pengadaan ON rencana_umum_pengadaan.organization = branch_agency.id_branch_agency JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil),

        (SELECT nama_organisasi FROM import_rencana_umum_pengadaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil))
        )AS nama_pemberi_kerja,




        IFNULL(
        (SELECT branch_agency.branch_name
        FROM branch_agency
        WHERE branch_agency.id_branch_agency = (

            SELECT branch_agency.id_suborganization_parent
            FROM branch_agency
            JOIN rencana_umum_pengadaan ON rencana_umum_pengadaan.organization = branch_agency.id_branch_agency
            JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
            JOIN daftar_proyek_berjalan ON daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil
            WHERE daftar_informasi_lelang.id_dil = daftar_proyek_berjalan.id_dil AND daftar_proyek_berjalan.id_dpb = dpb.id_dpb

            )

        ),

        null
        )AS pemberi_kerja_parent,

        IFNULL(
        (SELECT agency_category.agency_category_name FROM agency_category WHERE agency_category.id_agency_category =

            (SELECT branch_agency.id_agency_category FROM branch_agency WHERE branch_agency.id_branch_agency =

                (
                SELECT branch_agency.id_suborganization_parent
                FROM branch_agency
                JOIN rencana_umum_pengadaan ON rencana_umum_pengadaan.organization = branch_agency.id_branch_agency
                JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
                JOIN daftar_proyek_berjalan ON daftar_proyek_berjalan.id_dil = daftar_informasi_lelang.id_dil
                WHERE daftar_informasi_lelang.id_dil = daftar_proyek_berjalan.id_dil AND daftar_proyek_berjalan.id_dpb = dpb.id_dpb
                )))

        ,

        null
        ) AS nama_kategori_instansi_dari_parent,


        IFNULL((SELECT address FROM branch_agency WHERE id_branch_agency = dpb.id_pemberi_kerja),
        IFNULL((SELECT address FROM branch_agency JOIN rencana_umum_pengadaan ON rencana_umum_pengadaan.organization = branch_agency.id_branch_agency JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil),

        (SELECT alamat_organisasi FROM import_rencana_umum_pengadaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil))
        ) AS alamat_pemberi_kerja,

        IFNULL(
        dpb.nama_pekerjaan,
        IFNULL((SELECT nama_pekerjaan FROM rencana_umum_pengadaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil),

        (SELECT nama_pekerjaan FROM import_rencana_umum_pengadaan JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_rup = import_rencana_umum_pengadaan.id_rup
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil))
        ) AS nama_pekerjaan,

        dpb.nomor_kontrak AS nomor_kontrak,

        IFNULL(dpb.nilai_pekerjaan,
        (SELECT nilai_kontrak FROM hasil_lelang JOIN daftar_informasi_lelang ON daftar_informasi_lelang.id_dil = hasil_lelang.id_dil
        WHERE daftar_informasi_lelang.id_dil = dpb.id_dil)
        ) AS nilai_kontrak,

        dpb.jenis_pajak AS id_jenis_pajak,
        dpb.besaran_persentase_pajak AS besaran_persentase_pajak,

        (SELECT
                CASE
                        dpb.jenis_pajak
                        WHEN '0' THEN
                        'Belum Dipilih'
                        WHEN '1' THEN
                        'Termasuk PPN'
                        WHEN '2' THEN
                        'Tidak Termasuk PPN'
                        WHEN '3' THEN
                        'Tanpa PPN' ELSE dpb.jenis_pajak
                    END) AS nama_jenis_pajak,

        dpb.perubahan_nilai_pekerjaan AS perubahan_nilai_kontrak,

        (SELECT COUNT(nomor_termin) FROM termin_pembayaran_proyek_berjalan WHERE id_dpb = dpb.id_dpb) AS jumlah_termin_pembayaran,

        DATE_FORMAT(dpb.tanggal_kontrak_diterima, '%d %M %Y') AS tgl_terima_kontrak,

        CONCAT(DATE_FORMAT(dpb.jangka_waktu_mulai, '%d %M %Y'), ' s/d ',DATE_FORMAT(dpb.jangka_waktu_selesai, '%d %M %Y')) AS durasi_kontrak_pekerjaan,

        DATE_FORMAT(dpb.surat_referensi, '%d %M %Y') AS tgl_terima_surat_referensi,

        (SELECT DATE_FORMAT(formulir_informasi_pekerjaan.tanggal_bast, '%d %M %Y') FROM formulir_informasi_pekerjaan WHERE id_dpb = dpb.id_dpb) AS tgl_terima_bast,








        dpb.input_id AS id_pic_dpb,

        (SELECT CONCAT(users.first_name, ' ',users.last_name)
        FROM users
        WHERE id = dpb.pic_dpb
        ) AS pic_dpb,

        (SELECT email
        FROM users
        WHERE id = dpb.pic_dpb
        ) AS email_pic_dpb,

        (SELECT CONCAT(users.first_name, ' ',users.last_name)
        FROM users
        WHERE id = dpb.update_id
        ) AS perubahan_terakhir_oleh,
        dpb.updated_at AS tanggal_perubahan_terakhir,
        dpb.count_publish_dpb AS jumlah_publish,

        datediff(dpb.jangka_waktu_selesai, dpb.jangka_waktu_mulai) AS durasi_pekerjaan,
        dpb.keterangan_dpb AS keterangan_dpb,





        dpb.id_ppk AS id_ppk,
        dpb.id_pptk AS id_pptk,
        dpb.id_kpa AS id_kpa,
        dpb.id_pa AS id_pa,
        dpb.id_swasta AS id_swasta,
        DATE_FORMAT(dpb.jangka_waktu_mulai, '%d %M %Y') AS jangka_waktu_mulai,
        DATE_FORMAT(dpb.jangka_waktu_selesai, '%d %M %Y') AS jangka_waktu_selesai,
        dpb.perubahan_nilai_pekerjaan AS perubahan_nilai_pekerjaan,
        dpb.jenis_pajak AS jenis_pajak,

        dpb.is_objek_pekerjaan_alias AS is_objek_pekerjaan_alias,
        dpb.objek_pekerjaan_alias AS objek_pekerjaan_alias,
        dpb.lokasi_pekerjaan AS lokasi_pekerjaan,
        dpb.tanggal_kontrak AS tanggal_kontrak,
        dpb.input_id AS input_id,
        dpb.created_at AS created_at,
        dpb.update_id AS update_id,
        dpb.updated_at AS updated_at,
        dpb.nilai_pekerjaan AS nilai_pekerjaan,
        dpb.lama_pekerjaan AS lama_pekerjaan,
        dpb.jenis_lama_waktu AS jenis_lama_waktu,
        dpb.jumlah_ta_indonesia AS jumlah_ta_indonesia,
        dpb.is_validasi_keuangan AS is_validasi_keuangan

        FROM daftar_proyek_berjalan dpb
        ";

        $this->data['data_omzet'] = collect(DB::select($query))->where('id_dpb', $request->id_dpb)->first();

        return view('keuangan_omzet.form_validasi_keuangan', $this->data);
    }

    public function proses_validasi(Request $request)
    {
        $object = [
            'is_validasi_keuangan' => 'Valid'
        ];

        DB::table('daftar_proyek_berjalan')
              ->where('id_dpb', $request->id_dpb)
              ->update($object);

        return redirect()->to('keuangan-omzet')->with('success', 'Berhasil melakukan validasi');
        // dd($request->id_dpb);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
