<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dpb;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DpbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Daftar Proyek Berjalan";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));


        // var_dump(DB::table("view_dpb3")->get());
        $dpb = Dpb::orderBy('tahun_dpb', 'desc');

        if ($request->ajax()) {
            return Datatables::of($dpb)
                ->addIndexColumn()
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('search'))) {
                //         $instance->where(function ($w) use ($request) {
                //             $search = $request->get('search');
                //             $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                //                 ->orWhere('nama_organisasi', 'LIKE', "%$search%")
                //                 ->orWhere('id_sis_Dpb', 'LIKE', "%$search%");
                //         });
                //     }
                // })
                ->addColumn('pemberi_kerja', function ($row) {

                    // INSTANSI
                    $teks = $row->pemberi_kerja_parent;
                    $pecah = explode(" ", $teks);
                    $instansi = $pecah[0] == 'Pemerintah' ? trim(preg_replace("/Pemerintah/", "", $teks)) : $teks;
                    $nama_instansi = $row->nama_kategori_instansi_dari_parent == 'Kementerian' ?  $instansi : '';

                    $data = trim($row->nama_pemberi_kerja) . ' ' . $nama_instansi . '<br><span class="text-dark">' . $row->nomor_kontrak . '</span>';
                    return $data;
                })
                ->addColumn('kode', function ($row) {
                    $kode = '<b class="text-dark" style="font-size: 16px;">' . $row->kode_dpb . '</b><br>
                    <div class="dropdown dropdown-inline">
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Reply-all.svg--><svg
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                    viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M8.29606274,4.13760526 L1.15599693,10.6152626 C0.849219196,10.8935795 0.826147139,11.3678924 1.10446404,11.6746702 C1.11907213,11.6907721 1.13437346,11.7062312 1.15032466,11.7210037 L8.29039047,18.333467 C8.59429669,18.6149166 9.06882135,18.596712 9.35027096,18.2928057 C9.47866909,18.1541628 9.55000007,17.9721616 9.55000007,17.7831961 L9.55000007,4.69307548 C9.55000007,4.27886191 9.21421363,3.94307548 8.80000007,3.94307548 C8.61368984,3.94307548 8.43404911,4.01242035 8.29606274,4.13760526 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path
                                            d="M23.2951173,17.7910156 C23.2951173,16.9707031 23.4708985,13.7333984 20.9171876,11.1650391 C19.1984376,9.43652344 16.6261719,9.13671875 13.5500001,9 L13.5500001,4.69307548 C13.5500001,4.27886191 13.2142136,3.94307548 12.8000001,3.94307548 C12.6136898,3.94307548 12.4340491,4.01242035 12.2960627,4.13760526 L5.15599693,10.6152626 C4.8492192,10.8935795 4.82614714,11.3678924 5.10446404,11.6746702 C5.11907213,11.6907721 5.13437346,11.7062312 5.15032466,11.7210037 L12.2903905,18.333467 C12.5942967,18.6149166 13.0688214,18.596712 13.350271,18.2928057 C13.4786691,18.1541628 13.5500001,17.9721616 13.5500001,17.7831961 L13.5500001,13.5 C15.5031251,13.5537109 16.8943705,13.6779456 18.1583985,14.0800781 C19.9784273,14.6590944 21.3849749,16.3018455 22.3780412,19.0083314 L22.3780249,19.0083374 C22.4863904,19.3036749 22.7675498,19.5 23.0821406,19.5 L23.3000001,19.5 C23.3000001,19.0068359 23.2951173,18.2255859 23.2951173,17.7910156 Z"
                                            fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <ul class="navi flex-column navi-hover py-2">
                                <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                                    Choose an action:
                                </li>
                                <li class="navi-item">
                                    <a href="/dpb/detail/' . $row->id_dpb . '" class="navi-link" target="_blank">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Detail DPB</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="#" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Edit</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>';
                    return $kode;
                })
                ->addColumn('nama_pekerjaan_dpb', function ($row) {
                    $data = '<span style="color: #CB000D;" class="font-weight-bold">' . $row->nama_pekerjaan . '</span>';
                    return $data;
                })
                ->addColumn('nilai_kontrak_dpb', function ($row) {
                    $perubahan_nilai_kontrak = $row->perubahan_nilai_kontrak != '' ? '<hr>Perubahan Nilai Kontrak : <b style="color: blue; font-size: 14px;">' . number_format($row->perubahan_nilai_kontrak, 0, ",", ".") . '</b>' : '';

                    $data = '<b style="color:red; font-size: 14px;">' . number_format($row->nilai_kontrak, 0, ",", ".") . '</b>' . $perubahan_nilai_kontrak;
                    return $data;
                })
                ->addColumn('updated', function ($row) {

                    $data = '<span class="text-success">' . date('d/m/Y H:i:s', strtotime($row->tanggal_perubahan_terakhir)) . '<br>Oleh ' . $row->perubahan_terakhir_oleh . ' </span>
                    <br><span type="" style="cursor: pointer;" class="text-primary" data-toggle="modal" data-target="#detail_perubahan_dpb" data-placement="top" data-id="#" title="Informasi Perubahan DPB">Info Perubahan</span>';

                    return $data;
                })
                ->rawColumns(['pemberi_kerja', 'kode', 'nama_pekerjaan_dpb', 'nilai_kontrak_dpb', 'updated'])
                ->make(true);
        }


        return view('dpb.index', $this->data);
    }


    public function detail($id)
    {
        $this->data = [];
        $this->data['id'] = $id;
        $this->data['title'] = "Detail Proyek Berjalan";
        $this->data['data'] = collect(DB::select("SELECT * FROM view_dpb_marketing WHERE id_dpb = $id"))->first();
        

        // #PEMBERI KERJA
        // $teks = $this->data['data']->pemberi_kerja_parent;
        // $pecah = explode(" ", $teks);
        // $instansi = $pecah[0] == 'Pemerintah' ? trim(preg_replace("/Pemerintah/", "", $teks)) : $teks;
        // $nama_instansi = $this->data['data']->nama_kategori_instansi_dari_parent == 'Kementerian' ?  $instansi : '';
        // $this->data['pemberi_kerja'] = trim($this->data['data']->nama_pemberi_kerja) . ' ' . $nama_instansi;
        
        $this->data['ppk'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_ppk)->first();
        $this->data['pptk'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_pptk)->first();
        $this->data['kpa'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_kpa)->first();
        $this->data['pa'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_pa)->first();

        return view('dpb.detail', $this->data);
    }



    // public function export_dpb()
    // {
    //     $this->data = [];
    //     $this->data['title'] = "Export DPB";
    //     $users = DB::table('data_prospek')->get();
    //     dd($users);
    //     // return view('dpb.form_export_dpb', $this->data);
    // }

    // public function proses_export_dpb(Request $request)
    // {
    //     // print_r($request);
    //     echo $request->tahun_anggaran;
    // }
}
