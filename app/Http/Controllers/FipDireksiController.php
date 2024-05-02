<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\FipMkt;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class FipDireksiController extends Controller
{
    public function __construct()
    {
        setlocale(LC_TIME, 'id_ID');
        Carbon::setLocale('id');
    }

    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "FIP DIREKSI";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));


        // date('Y')
        $fipMo = DB::table('view_fip_direksi');
        if ($request->ajax()) {
            return Datatables::of($fipMo)
                ->addIndexColumn()
                ->addColumn('kode_fip', function ($row) {
                    $kode = '<b class="text-dark" style="font-size: 16px;">' . $row->kode . '</b><br>
                    <div class="dropdown dropdown-inline">
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
                            <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
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
                                    <a href="/fip-mkt/detail/' . $row->id_fip . '" class="navi-link" target="_blank">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Detail FIP</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/fip-direksi/catatan/' . $row->id_fip . '" class="navi-link" target="_blank">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Beri Catatan</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a onclick="showTunjukPIC(' . $row->id_fip . ')" href="#modal_tunjuk_pic" data-toggle="modal" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Tunjuk PIC Adpro & Konsultan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>';
                    return $kode;
                })
                ->addColumn('nama_pekerjaan_fip', function ($row) {
                    $data = '<span style="color: #CB000D;" class="font-weight-bold">' . $row->nama_pekerjaan . '</span>
                    <hr>
                    <i style="font-size:13px; color:grey;">' . $row->nama_bidang_pekerjaan . '</i>';
                    return $data;
                })
                ->addColumn('durasi_kerja', function ($row) {
                    $ht_hari = $row->durasi_pekerjaan % 30;
                    $ht_bulan = floor($row->durasi_pekerjaan / 30);
                    $hari = ($ht_hari != 0) ? $ht_hari . ' hari' : '';
                    $bulan = ($ht_bulan != 0) ? $ht_bulan . ' bulan' : '';
                    $durasi = $bulan . ' ' . $hari;

                    $data = $row->durasi_kontrak_pekerjaan . ' <br><span class="font-weight-bold text-dark">(' . $durasi . ')</span>';
                    return $data;
                })
                ->addColumn('tanggal_bast', function ($row) {

                    $data = $row->tgl_bast != '' ? Carbon::parse($row->tgl_bast)->isoFormat('D MMMM Y') : '';
                    return $data;
                })
                ->addColumn('updated', function ($row) {

                    if ($row->tgl_perubahan_terakhir != '') {
                        $data = '<span class="text-secondary">' . date('d/m/Y H:i:s', strtotime($row->tgl_perubahan_terakhir)) . '<br>Oleh ' . $row->nama_pic_perubahan_terakhir . ' </span>';
                    } else {
                        $data = '<i style="font-size:13px; color:grey;">Belum ada perubahan fip.</i>';
                    }
                    return $data;
                })
                ->addColumn('acc_oleh', function ($row) {

                    $acc_mo = ($row->is_acc_mo == 1) ? '<b>GM</b> : ' . $row->nama_pic_acc_mo . ' pada ' . date('d/m/Y', strtotime($row->tgl_acc_mo)) : '';

                    $acc_direksi = ($row->is_acc_direksi == 1) ? '<hr><b>DIREKSI</b> : ' . $row->nama_pic_acc_direksi . ' pada ' . date('d/m/Y', strtotime($row->tgl_acc_direksi)) : '';

                    $data = $acc_mo . $acc_direksi;
                    return $data;
                })
                ->addColumn('btn_approve', function ($row) {
                    if($row->is_acc_mo == 1 || $row->is_acc_direksi == 1){
                        $data = '<a class="btn btn-secondary btn-sm font-weight-bold disabled"><i class="fas fa-check"></i> Approved</a>';

                    } else {
                        if($row->pic_adpro != '' || $row->pic_konsultan != ''){
                            $data = '<a href="javascript:void(0)" onclick="approved(' . "'" . $row->id_fip . "', '" . $row->kode . "'" . ')" class="btn btn-success btn-sm font-weight-bold"><i class="fas fa-check"></i> Approved</a>';
                        } else {
                            $data = '<a onclick="alert()" class="btn btn-success btn-sm font-weight-bold"><i class="fas fa-check"></i> Approved</a>';
                        }
                    }
                    return $data;
                })
                ->rawColumns(['kode_fip', 'nama_pekerjaan_fip', 'durasi_kerja', 'tanggal_bast', 'updated', 'acc_oleh', 'btn_approve'])
                ->filter(function ($instance) use ($request) {
                    if ($request->get('tahun') != '') {
                        $instance->where('tahun_anggaran', $request->get('tahun'));
                    } else {
                        $instance->where('tahun_anggaran', 2023);
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                                ->orWhere('kode', 'LIKE', "%$search%");
                        });
                    }
                })
                ->make(true);
        }
        return view('fip_direksi.index', $this->data);
        // echo  Carbon::now()->isoFormat('D MMMM Y');
    }



    public function modal_tunjuk_pic($id)
    {
        $this->data = [];
        $this->data['fip'] = DB::table('view_fip_direksi')->where('id_fip', $id)->first();
        // echo $id;

        return view('fip_direksi.modal_tunjuk_pic', $this->data);
    }

    public function tunjuk_pic(Request $request, $id)
    {
        $object = [
            'id_admin_proyek'   => $request['id_admin_proyek'],
            'id_konsultan'      => $request['id_konsultan']
        ];
        // var_dump($object);
        DB::table("formulir_informasi_pekerjaan")->where('id_fip', $id)->update($object);

        return response()->json();
    }


    public function approved(Request $request, $id)
    {
        $this->data = [];
        $this->data['fip'] = DB::table('view_fip_direksi')->where('id_fip', $id)->first();
        $fip = $this->data['fip'];

        // return view('fip_direksi.approve_email', $this->data);
        Mail::send('fip_direksi.approve_email', $this->data, function ($message) use ($fip) {
            $message->from('sim@kokek.com', 'SIM PT.KOKEK')
                ->to(['programmer@kokek.com'])
                ->subject('FIP ' . $fip->nama_pekerjaan);
        });

        $object = [
			'is_approve_direksi'        	=> 1,
			'approve_direksi_id'        	=> Session::get('id_users'),
			'approve_direksi_at'			=> now()
		];
        DB::table("formulir_informasi_pekerjaan")->where('id_fip', $id)->update($object);

        echo json_encode(["status" => true]);

    }


    public function catatan($id)
    {
        $this->data = [];
        $this->data['title'] = "Beri Catatan FIP";
        $this->data['fip'] = DB::table('view_fip_marketing')->where('id_fip', $id)->first();


        return view('fip_direksi.catatan', $this->data);
    }


    public function add_catatan(Request $request)
    {
        $object = [
            'id_fip'            => $request['id_fip'],
            'jenis_catatan'     => $request['jenis_catatan'],
            'tanggal_catatan'   => $request['tanggal_catatan'],
            'isi_catatan'       => $request['isi_catatan']
        ];
        // var_dump($object);
        DB::table("catatan_fip")->insert($object);

        Alert::success('Success', 'Berhasil Menambah Catatan');
        return redirect('fip-direksi/catatan/' . $request['id_fip']);
    }

    public function edit_catatan(Request $request, $id)
    {
        $object = [
            'tanggal_catatan'   => $request['tanggal_catatan'],
            'isi_catatan'       => $request['isi_catatan']
        ];
        DB::table("catatan_fip")->where('id_catatan_fip', $id)->update($object);

        Alert::success('Success', 'Berhasil Mengubah Catatan');
        return redirect('fip-direksi/catatan/' . $request['id_fip']);
    }

    public function delete_catatan($id)
    {
        DB::table('catatan_fip')->where('id_catatan_fip', $id)->delete();

        echo json_encode(array("status" => true));
    }


    public function export(Request $request)
    {
        $this->data = [];
        $this->data['mulai'] = $request['mulai'];
        $this->data['sampai'] = $request['sampai'];
        $this->data['fip'] = DB::table('view_fip_direksi')->where('tahun_anggaran', $this->data['mulai'])
                            ->orWhere('tahun_anggaran',  $this->data['sampai'])
                            ->orderBy('tahun_anggaran', 'desc');

        $tahun = $this->data['mulai'] == $this->data['sampai'] ? $this->data['mulai'] : $this->data['mulai'] . '-' . $this->data['sampai'];

        $content = view('fip_direksi.export', $this->data);
        $status = 200;
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="Fip-Periode-' . $tahun . '.xls"',
        ];
        return response($content, $status, $headers);
    }
}