<?php

namespace App\Http\Controllers;

use App\Models\JenisPekerjaan;
use App\Models\BidangPekerjaan;
use Illuminate\Http\Request;
use App\Models\PengalamanPerusahaan;

class PengalamanPerusahaanController extends Controller
{

    private $data;

    public function index(Request $request)
    {
        // $katakunci = $request->katakunci;
        $jumlahbaris = 15;

        $this->data = [];
        $this->data['title'] = "Pengalaman Perusahaan";

        // $query = PengalamanPerusahaan::select('*');
        $query = collect(PengalamanPerusahaan::semua());

        if ($request->katakunci) {

            $query = $query->where('nama_pekerjaan', 'like', "%$request->katakunci%");

        }

        if ($request->jenis_pekerjaan) {

            $query = $query->whereIn('id_jenis_pekerjaan_dpb', $request->jenis_pekerjaan);
        }

        if ($request->bidang_pekerjaan) {
            $bidang_pekerjaan = $request->bidang_pekerjaan;

            $query = $query->whereIn('id_bidang_pekerjaan', $bidang_pekerjaan);
        }


        if ($request->tahun_mulai) {
            $tahun_mulai = $request->tahun_mulai;
            $tahun_sampai = $request->tahun_sampai;

            $query = $query->whereBetween('tahun', [$tahun_mulai, $tahun_sampai]);
        }


        if ($request->nilai_kontrak_dari) {
            $nilai_kontrak_dari = str_replace(".","", $request->nilai_kontrak_dari);
            $nilai_kontrak_sampai = str_replace(".","", $request->nilai_kontrak_sampai);

            $query = $query->whereBetween('nilai_kontrak_kerja', [(int)$nilai_kontrak_dari, (int)$nilai_kontrak_sampai]);
        }

        if (strlen($request->pengurutan_nilai_pekerjaan)) {

            $sort = ($request->pengurutan_nilai_pekerjaan == 'Ascending') ? 'sortBy' : 'sortByDesc';

            $query = $query->$sort('nilai_kontrak_kerja');

        }



        // $this->data['pengalaman_perusahaan'] = $query->get();
        $this->data['data_pengalaman'] = $query;

        $this->data['bidang_pekerjaan'] = BidangPekerjaan::get();
        $this->data['data_jenis_pekerjaan'] = JenisPekerjaan::get();

        // $this->data['data_pengalaman'] = collect(PengalamanPerusahaan::semua());

        return view('pengalaman_perusahaan.index', $this->data);




        // PengalamanPerusahaan::chunk(200, function ($data_pengalaman) {
        //     $no = 1;
        //     foreach ($data_pengalaman as $pengalaman) {
        //         echo $no++.' '.$pengalaman->nama_pekerjaan.'<br>';
        //     }
        // });

        // $query = collect(PengalamanPerusahaan::semua());

        // dd($query);
    }

    public function generate_chart(Request $request)
    {
        $this->data = [];

        $jumlah_data = count($request->nama_pekerjaan);

        $arr_data = [];
        for ($i=0; $i < $jumlah_data; $i++) {
            $arr_data[] = [$request->nama_pekerjaan[$i], $request->nett_omzet[$i]];
        }

        $this->data['arr_data'] = $arr_data;
        $this->data['jumlah_data'] = $jumlah_data;

        return view('pengalaman_perusahaan.generate_chart', $this->data);
    }
}
