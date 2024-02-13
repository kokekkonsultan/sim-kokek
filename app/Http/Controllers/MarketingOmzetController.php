<?php

namespace App\Http\Controllers;

use App\Models\BidangPekerjaan;
use App\Models\JenisPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OmzetDpb;

class MarketingOmzetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $data;

    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Omzet";

        $query = collect(OmzetDpb::semua());

        if ($request->tahun && $request->tahun_sampai) {

            $query = $query->whereBetween('tahun_dpb', [$request->tahun, $request->tahun_sampai]);

        } else {
            $query = $query->where('tahun_dpb', date('Y'));
        }

        if ($request->jenis_pekerjaan) {

            $query = $query->whereIn('id_jenis_pekerjaan_dpb', $request->jenis_pekerjaan);
        }

        if ($request->bidang_pekerjaan) {

            $query = $query->whereIn('id_bidang_pekerjaan', $request->bidang_pekerjaan);
        }

        if (strlen($request->validasi_keuangan)) {

            $query = $query->where('is_validasi_keuangan', $request->validasi_keuangan);

        }

        if (strlen($request->pengurutan_nilai_pekerjaan)) {

            $sort = ($request->pengurutan_nilai_pekerjaan == 'Ascending') ? 'sortBy' : 'sortByDesc';

            $query = $query->$sort('nilai_kontrak');

        }

        if (strlen($request->keyword)) {

            $productName = $request->keyword;
            $query = $query->filter(function ($item) use ($productName) {
                // replace stristr with your choice of matching function
                // return false !== stristr($item->nama_pekerjaan, $productName);
                return false !== stripos($item->nama_pekerjaan, $productName);
            });

        }

        $this->data['data_omzet'] = $query;

        /*if (strlen($tahun) && strlen($tahun_sampai)) {


            if (strlen($validasi_keuangan)) {
                if ($validasi_keuangan == 'Belum Divalidasi') {
                    $this->data['data_omzet'] = collect(OmzetDpb::semua())->whereBetween('tahun_dpb', [$tahun, $tahun_sampai])->where('is_validasi_keuangan', null);
                } else {
                    $this->data['data_omzet'] = collect(OmzetDpb::semua())->whereBetween('tahun_dpb', [$tahun, $tahun_sampai])->where('is_validasi_keuangan', $validasi_keuangan);
                }

            } else {

                // $this->data['data_omzet'] = collect(OmzetDpb::semua())->where('tahun_dpb', $tahun);

                if (strlen($pengurutan_nilai_pekerjaan)) {



                    $sort = ($pengurutan_nilai_pekerjaan == 'Ascending') ? 'sortBy' : 'sortByDesc';

                    $this->data['data_omzet'] = collect(OmzetDpb::semua())->whereBetween('tahun_dpb', [$tahun, $tahun_sampai])->$sort('nilai_kontrak');

                } else {
                    $this->data['data_omzet'] = collect(OmzetDpb::semua())->whereBetween('tahun_dpb', [$tahun, $tahun_sampai]);
                }


            }

        } else {

            $this->data['data_omzet'] = collect(OmzetDpb::semua())->where('tahun_dpb', date('Y'));

            // $this->data['data_omzet'] = collect(OmzetDpb::semua())->groupBy('tahun_dpb')->sortKeys();
        }*/

        // $this->data['arr_data_bidang_pekerjaan']  = collect(BidangPekerjaan::pluck('id_bidang_pekerjaan'))->toArray();
        $this->data['data_bidang_pekerjaan'] = BidangPekerjaan::get();
        $this->data['data_jenis_pekerjaan'] = JenisPekerjaan::get();

        // dd($this->data['data_omzet']);
        return view('marketing_omzet.index', $this->data);
    }

    public function get_nilai_pekerjaan()
    {
        $data = collect(OmzetDpb::semua())->groupBy('tahun_dpb')->sortKeys();

        // dd($data);

        $jum_tahun = 0;
        $tot_nilai_pekerjaan = 0;

        foreach ($data as $key => $item) {

            // echo $key.'<br/>';

            $nett_omzet_keseluruhan = 0;

            foreach ($item as $value) {



                if ($value->besaran_persentase_pajak != '') {
                    $persentase_pajak = $value->besaran_persentase_pajak;
                } else {
                    $persentase_pajak = 10; // Jika kosong otomatis persentase pajak 10%
                }

                $nilai_ppn = ($persentase_pajak / 100);
                $nilai_pph = 0.02;
                $nilai_dpp = 1.11;

                if ($value->id_jenis_pajak == 1) { // Termasuk Pajak

                    $dpp = $value->nilai_kontrak /  $nilai_dpp;
                    $pajak_ppn = $dpp * $nilai_ppn;
                    $pajak_pph = $dpp * $nilai_pph;

                } elseif ($value->id_jenis_pajak == 2) { // Tidak Termasuk Pajak

                    $dpp = $value->nilai_kontrak /  $nilai_dpp;
                    $pajak_ppn = 0;
                    $pajak_pph = $dpp * $nilai_pph;

                } else { // Tanpa Pajak atau tidak dikenakan pajak

                    $dpp = $value->nilai_kontrak;
                    $pajak_ppn = 0;
                    $pajak_pph = 0;

                }

                $nett_omzet = ($value->nilai_kontrak - $pajak_ppn - $pajak_pph);
                $nett_omzet_keseluruhan += $nett_omzet;

            }


            $arr_1[] = [
                'label' => "$key",
                'value' => (float) $nett_omzet_keseluruhan,
            ];


            $tot_nilai_pekerjaan += $nett_omzet_keseluruhan;
            $jum_tahun++;

        }

        // dd($arr_1);
        // echo $jum_tahun;

        $this->data['arr_1'] = $arr_1;
        $this->data['rata_rata_nilai_pekerjaan'] = $tot_nilai_pekerjaan/$jum_tahun;

        return view('marketing_omzet/chart_nilai_pekerjaan', $this->data);

    }

    public function get_jumlah_pekerjaan()
    {
        $data = collect(OmzetDpb::semua())->groupBy('tahun_dpb')->sortKeys();

        $jum_tahun = 0;
        $tot_nilai_pekerjaan = 0;
        foreach ($data as $key => $value) {

            $query_total = $value->sum('nilai_kontrak');

            $query_jumlah_pekerjaan = $value->count();

            $tahun[] = $value;
            $nilai_pekerjaan[] = (float) $query_total;
            $jumlah_pekerjaan[] = $query_jumlah_pekerjaan;

            $arr_1[] = [
            'label' => $key,
            'value' => (float) $query_total,
            ];

            $arr_2[] = [
            'label' => "$key",
            'value' => $query_jumlah_pekerjaan
            ];

            $tot_nilai_pekerjaan += $query_total;
            $jum_tahun++;

        }

        // dd($arr_2);
        $this->data['arr_2'] = $arr_2;
        // $this->data['rata_rata_nilai_pekerjaan'] = $tot_nilai_pekerjaan/$jum_tahun;

        return view('marketing_omzet/chart_jumlah_pekerjaan', $this->data);
    }

    public function generate_chart(Request $request)
    {
        // dd($request);

        $this->data = [];

        $jumlah_data = count($request->nama_pekerjaan);

        $arr_data = [];
        for ($i=0; $i < $jumlah_data; $i++) {
            $arr_data[] = [$request->nama_pekerjaan[$i], $request->nett_omzet[$i]];
        }

        // dd($arr_data);

        $this->data['arr_data'] = $arr_data;
        $this->data['jumlah_data'] = $jumlah_data;

        return view('marketing_omzet.generate_chart', $this->data);
    }


}
