<?php

namespace App\Http\Controllers;

use App\Models\Rup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TidakProspekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Data Tidak Prospek";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));



        // $this->data['data_rup'] = collect(Rup::get()->where('tahun_anggaran', '2023'));
        // date('Y')
        $years = 2024;
        $rup = Rup::where('tahun_anggaran', date('Y'))
            ->where('is_diproses_di_dil', 2)
            ->where('is_pekerjaan_prospek', 1);

        if ($request->ajax()) {
            return Datatables::of($rup)
                ->addIndexColumn()
                ->addColumn('paket', function ($row) {

                    // if ($row->id_status_kirim_penawaran == 1) {
                    //     $status_kirim_penawaran = '<span class="badge badge-success">' . $row->nama_status_kirim_penawaran . '</span>';
                    // } elseif ($row->id_status_kirim_penawaran == 2) {
                    //     $status_kirim_penawaran = '<span class="badge badge-danger">' . $row->nama_status_kirim_penawaran . '</span>';
                    // } else {
                    //     $status_kirim_penawaran = '<span class="badge badge-dark">' . $row->nama_status_kirim_penawaran . '</span>';
                    // }

                    $paket = '<span class="text-danger">' . $row->nama_pekerjaan . '</span><br><small>' . $row->nama_bidang_pekerjaan . '</small>
                    <br>
                    <div class="dropdown dropdown-inline">
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Reply-all.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M8.29606274,4.13760526 L1.15599693,10.6152626 C0.849219196,10.8935795 0.826147139,11.3678924 1.10446404,11.6746702 C1.11907213,11.6907721 1.13437346,11.7062312 1.15032466,11.7210037 L8.29039047,18.333467 C8.59429669,18.6149166 9.06882135,18.596712 9.35027096,18.2928057 C9.47866909,18.1541628 9.55000007,17.9721616 9.55000007,17.7831961 L9.55000007,4.69307548 C9.55000007,4.27886191 9.21421363,3.94307548 8.80000007,3.94307548 C8.61368984,3.94307548 8.43404911,4.01242035 8.29606274,4.13760526 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path d="M23.2951173,17.7910156 C23.2951173,16.9707031 23.4708985,13.7333984 20.9171876,11.1650391 C19.1984376,9.43652344 16.6261719,9.13671875 13.5500001,9 L13.5500001,4.69307548 C13.5500001,4.27886191 13.2142136,3.94307548 12.8000001,3.94307548 C12.6136898,3.94307548 12.4340491,4.01242035 12.2960627,4.13760526 L5.15599693,10.6152626 C4.8492192,10.8935795 4.82614714,11.3678924 5.10446404,11.6746702 C5.11907213,11.6907721 5.13437346,11.7062312 5.15032466,11.7210037 L12.2903905,18.333467 C12.5942967,18.6149166 13.0688214,18.596712 13.350271,18.2928057 C13.4786691,18.1541628 13.5500001,17.9721616 13.5500001,17.7831961 L13.5500001,13.5 C15.5031251,13.5537109 16.8943705,13.6779456 18.1583985,14.0800781 C19.9784273,14.6590944 21.3849749,16.3018455 22.3780412,19.0083314 L22.3780249,19.0083374 C22.4863904,19.3036749 22.7675498,19.5 23.0821406,19.5 L23.3000001,19.5 C23.3000001,19.0068359 23.2951173,18.2255859 23.2951173,17.7910156 Z" fill="#000000" fill-rule="nonzero"></path>
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
                                    <a href="javascript:void(0)" class="navi-link" onclick="jadikan_prospek(' . "'" . $row->id_rup . "', '" . $row->nama_pekerjaan . "'" . ')">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Pindahkan Ke Prospek</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="javascript:void(0)" class="navi-link" onclick="jadikan_rup(' . "'" . $row->id_rup . "', '" . $row->nama_pekerjaan . "'" . ')">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Pindahkan Ke RUP</span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>';
                    return $paket;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                                ->orWhere('nama_organisasi', 'LIKE', "%$search%");
                        });
                    }
                })
                // ->addColumn('pagu_rupiah', function ($row) {
                //     $pagu_rupiah = number_format($row->pagu,0,",",".");
                //     return $pagu_rupiah;
                // })
                ->rawColumns(['paket', 'pagu_rupiah'])
                ->make(true);
        }


        return view('tidak_prospek.index', $this->data);
    }

    public function ubah_ke_prospek($id)
    {
        // Cek data input atau import
        $query = DB::table('view_rencana_umum_pengadaan')->where('id_rup', $id)->first();

        if ($query->is_import == 1) {
            DB::table('import_rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => 2, 'updated_at' => now()]);
        } else {

            DB::table('rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => 2, 'updated_at' => now()]);
        }

        echo json_encode(array("status" => true));
    }

    public function ubah_ke_rup($id)
    {
        // Cek data input atau import
        $query = DB::table('view_rencana_umum_pengadaan')->where('id_rup', $id)->first();

        if ($query->is_import == 1) {
            DB::table('import_rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => null, 'updated_at' => now()]);
        } else {

            DB::table('rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => null, 'updated_at' => now()]);
        }

        echo json_encode(array("status" => true));
    }

     // public function delete_data($id)
    // {

    //     if (DB::table('import_rencana_umum_pengadaan')->where('id_rup', $id)->count() > 0) {
    //         DB::table('import_rencana_umum_pengadaan')->where('id_rup', $id)->delete();
    //     } else {
    //         DB::table('rencana_umum_pengadaan')->where('id_rup', $id)->delete();
    //     }
    //     echo json_encode(array("status" => true));
    // }
}
