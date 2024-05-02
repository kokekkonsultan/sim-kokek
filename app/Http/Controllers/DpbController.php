<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dpb;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DaftarPenawaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
                ->addColumn('pemberi_kerja', function ($row) {

                    // INSTANSI
                    $teks = $row->pemberi_kerja_parent;
                    $pecah = explode(" ", $teks);
                    $instansi = $pecah[0] == 'Pemerintah' ? trim(preg_replace("/Pemerintah/", "", $teks)) : $teks;
                    $nama_instansi = $row->nama_kategori_instansi_dari_parent == 'Kementerian' ?  $instansi : '';

                    $data = trim($row->nama_pemberi_kerja) . ' ' . $nama_instansi;
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
                                    <a href="javascript:void(0)" onclick="publish(' . $row->id_dpb . ')" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Publish ' . $row->jumlah_publish . '</span>
                                    </a>
                                </li>
                                
                                <li class="navi-item">
                                    <a href="/dpb/form-edit/' . $row->id_dpb . '" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Edit</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>';
                    return $kode;
                    // <button type="button" class="btn btn-primary btn-lg font-weight-bolder" onclick='publish_dil("{{$dil->nama_pekerjaan}}")'><i class="fa fa-share"></i> Publish Hasil Lelang</button>
                })
                ->addColumn('nama_pekerjaan_dpb', function ($row) {
                    $data = '<span style="color: #CB000D;" class="font-weight-bold">' . $row->nama_pekerjaan . '</span>
                    <br>
                    <i style="font-size:13px; color:grey;">' . $row->nomor_kontrak . '</i>';
                    return $data;
                })
                ->addColumn('nilai_kontrak_dpb', function ($row) {
                    $perubahan_nilai_kontrak = $row->perubahan_nilai_kontrak != '' ? '<hr>Perubahan Nilai Kontrak : <b style="color: blue; font-size: 14px;">' . number_format($row->perubahan_nilai_kontrak, 0, ",", ".") . '</b>' : '';

                    $data = '<b style="color:red; font-size: 14px;">' . number_format($row->nilai_kontrak, 0, ",", ".") . '</b>' . $perubahan_nilai_kontrak;

                    return $data;
                })
                ->addColumn('updated', function ($row) {

                    if($row->tanggal_perubahan_terakhir != ''){
                        $data = '<a data-toggle="modal" onclick="showInfoPerubahan(' . $row->id_dpb . ')" data-toggle="modal" href="#modal_info_perubahan" title="Informasi Perubahan DPB" class="font-weight-bold">
                        <span class="text-success">' . date('d/m/Y H:i:s', strtotime($row->tanggal_perubahan_terakhir)) . '<br>Oleh ' . $row->perubahan_terakhir_oleh . ' </span>
                        <br>
                        Info Perubahan</a>';
                    } else {
                        $data = '<i style="font-size:13px; color:grey;">Belum ada perubahan DPB.</i>';
                    }

                    

                    return $data;
                })
                ->addColumn('tanggal_terima_kontrak', function ($row) {

                    $data = $row->tgl_terima_kontrak . ' <a title="Ubah tanggal kontrak diterima" class="link-box" data-toggle="modal" onclick="showTerimaKontrak(' . $row->id_dpb . ')" href="#modal_terima_kontrak"><i class="fas fa-exchange-alt"></i></a>';

                    return $data;
                })
                ->addColumn('tanggal_terima_surat_referensi', function ($row) {

                    $data = $row->tgl_terima_surat_referensi . ' <a class="link-box" data-toggle="modal" title="Ubah Tanggal Terima SUrat Referensi" onclick="showTerimaSuratReferensi(' . $row->id_dpb . ')" href="#modal_terima_surat_referensi"><i class="fas fa-exchange-alt"></i></a>';

                    return $data;
                })

                ->rawColumns(['pemberi_kerja', 'kode', 'nama_pekerjaan_dpb', 'nilai_kontrak_dpb', 'updated', 'tanggal_terima_kontrak', 'tanggal_terima_surat_referensi'])
                ->filter(function ($instance) use ($request) {

                    // if ($request->get('id_bidang_pekerjaan') != '') {
                    //     $instance->where('id_bidang_pekerjaan_dpb', $request->get('id_bidang_pekerjaan'));
                    // }

                    if ($request->get('tahun') != '') {
                        $instance->where('tahun_dpb', $request->get('tahun'));
                    } else {
                        $instance->where('tahun_dpb', date('Y'));
                    }

                   

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                                ->orWhere('nama_pemberi_kerja', 'LIKE', "%$search%")
                                ->orWhere('kode_dpb', 'LIKE', "%$search%");
                        });
                    }
                })
                ->make(true);
        }


        return view('dpb.index', $this->data);
    }


    public function detail($id)
    {
        $this->data = [];
        $this->data['id'] = $id;
        $this->data['title'] = "Detail Proyek Berjalan";
        $this->data['data'] = collect(DB::select("SELECT * FROM view_dpb WHERE id_dpb = $id"))->first();


        $this->data['ppk'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_ppk)->first();
        $this->data['pptk'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_pptk)->first();
        $this->data['kpa'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_kpa)->first();
        $this->data['pa'] = DB::table('contact_person')->where('id_contact_person', $this->data['data']->id_pa)->first();

        return view('dpb.detail', $this->data);
    }

    public function cari_id_dil($id = 0)
    {
        $data = DaftarPenawaran::where('id_dil', $id)->first();
        echo json_encode($data);
    }

    public function form_add($id)
    {
        $this->data = [];
        $this->data['title'] = "Tambah Daftar Proyek Berjalan";

        $tahun_dpb = date('Y');
        $maxCode = collect(DB::select("SELECT SUBSTR(MAX(kode_dpb), 3) AS max FROM daftar_proyek_berjalan WHERE tahun_dpb = $tahun_dpb"))->first()->max;
        $this->data['kode_dpb'] = substr($tahun_dpb, 2, 2) . '' . sprintf("%02s", ($maxCode + 1));
        $this->data['jenis_pekerjaan'] = DB::table("jenis_pekerjaan")->where('id_jenis_pekerjaan', $id)->first()->nama_jenis_pekerjaan;
        $this->data['tahun_dpb'] = $tahun_dpb;

        return view('dpb.form_add', $this->data);
    }


    public function proses_add(Request $request, $id)
    {
        $split = explode("/", str_replace(" ", "", $request['durasi_pekerjaan']));
        $jangka_waktu_mulai = $split[0];
        $jangka_waktu_selesai = $split[1];
        $besaran_persentase_pajak = $request['jenis_pajak'] == 1 ? $request['persentase_pajak'] : '';

        $object = [
            'tahun_dpb'                 => $request['tahun_dpb'],
            'kode_dpb'                  => $request['kode_dpb'],
            'id_jenis_pekerjaan'        => $id,
            'lokasi_pekerjaan'          => $request['lokasi_pekerjaan'],

            'nomor_kontrak'             => $request['nomor_kontrak'],
            'tanggal_kontrak'           => date('Y-m-d', strtotime($request['tanggal_kontrak'])),
            'jangka_waktu_mulai'        => $jangka_waktu_mulai,
            'jangka_waktu_selesai'      => $jangka_waktu_selesai,
            'nilai_pekerjaan'           => str_replace([".", ","], '', $request['nilai_pekerjaan']),

            'jenis_pajak'               => $request['jenis_pajak'],
            'besaran_persentase_pajak'  => $besaran_persentase_pajak,

            // 'is_objek_pekerjaan_alias'  => $request['is_objek_pekerjaan_alias'],
            // 'objek_pekerjaan_alias'     => $request['objek_pekerjaan_alias'],

            'id_ppk'                    => $request['id_ppk'],
            'id_pptk'                   => $request['id_pptk'],
            'id_kpa'                    => $request['id_kpa'],
            'id_pa'                     => $request['id_pa'],
            'keterangan_dpb'            => $request['keterangan_dpb'],

            'pic_dpb'                   => Session::get('id_users'),
            'input_id'                  => Session::get('id_users'),
            'created_at'                => now()
        ];

        #jika lelang
        if ($id == 1) {
            $object['id_dil']                   = $request['id_dil'];
        } else {
            $object['id_pemberi_kerja']         = $request['id_pemberi_kerja'];
            $object['id_bidang_pekerjaan_dpb']  = $request['id_bidang_pekerjaan'];
            $object['nama_pekerjaan']           = $request['nama_pekerjaan'];
            $object['tahun_anggaran']           = $request['tahun_anggaran'];
        }
        // var_dump($object);
        DB::table("daftar_proyek_berjalan")->insert($object);
        $id_dpb = DB::getPdo()->lastInsertId();

        $result = [
            'id_dpb' => $id_dpb
        ];
        DB::table("dpb_biaya")->insert($result);



        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_dpb'            => $id_dpb,
            'aktivitas'         => 'Menambah Daftar Proyek Berjalan (DPB)',
            'created_at'        => now()
        ];
        if($id != 1){
            $log['id_branch_agency']         = $request['id_pemberi_kerja'];
        }

        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================


        return redirect('dpb/form-next-add/' . $id_dpb);

        // Alert::success('Success', 'Berhasil Menambah Data DPB');
        // return redirect('dpb/' . Session::get('id_users'));
    }

    public function form_next_add($id)
    {
        $this->data = [];
        $this->data['id'] = $id;
        $this->data['title'] = "Tambah Daftar Proyek Berjalan";
        $this->data['dpb'] = collect(DB::select("SELECT * FROM view_dpb WHERE id_dpb = $id"))->first();


        return view('dpb.form_next_add', $this->data);
    }

    public function proses_next_add(Request $request, $id)
    {
        $object = [
            'is_objek_pekerjaan_alias'  => $request['is_objek_pekerjaan_alias'],
            'objek_pekerjaan_alias'     => $request['objek_pekerjaan_alias'],
        ];
        DB::table("daftar_proyek_berjalan")->where('id_dpb', $id)->update($object);

        Alert::success('Success', 'Berhasil Melengkapi Data DPB');
        return redirect('dpb/' . Session::get('id_users'));
    }



    public function form_edit($id)
    {
        $this->data = [];
        $this->data['title'] = "Ubah Daftar Proyek Berjalan";
        $this->data['id'] = $id;
        $this->data['dpb'] = collect(DB::select("SELECT * FROM view_dpb WHERE id_dpb = $id"))->first();

        return view('dpb.form_edit', $this->data);
    }

    public function proses_edit(Request $request, $id)
    {
        $dpb = collect(DB::select("SELECT * FROM view_dpb WHERE id_dpb = $id"))->first();


        $split = explode("/", str_replace(" ", "", $request['durasi_pekerjaan']));
        $jangka_waktu_mulai = $split[0];
        $jangka_waktu_selesai = $split[1];
        $besaran_persentase_pajak = $request['jenis_pajak'] == 1 ? $request['persentase_pajak'] : '';

        $object = [
            'lokasi_pekerjaan'          => $request['lokasi_pekerjaan'],

            'nomor_kontrak'             => $request['nomor_kontrak'],
            'tanggal_kontrak'           => date('Y-m-d', strtotime($request['tanggal_kontrak'])),
            'jangka_waktu_mulai'        => $jangka_waktu_mulai,
            'jangka_waktu_selesai'      => $jangka_waktu_selesai,
            'nilai_pekerjaan'           => str_replace([".", ","], '', $request['nilai_pekerjaan']),

            'jenis_pajak'               => $request['jenis_pajak'],
            'besaran_persentase_pajak'  => $besaran_persentase_pajak,

            'is_objek_pekerjaan_alias'  => $request['is_objek_pekerjaan_alias'],
            'objek_pekerjaan_alias'     => $request['objek_pekerjaan_alias'],

            'id_ppk'                    => $request['id_ppk'],
            'id_pptk'                   => $request['id_pptk'],
            'id_kpa'                    => $request['id_kpa'],
            'id_pa'                     => $request['id_pa'],
            'keterangan_dpb'            => $request['keterangan_dpb'],

            'updated_at'                => now()
        ];

        #jika lelang
        if ($dpb->jenis_pekerjaan_dpb != 'Lelang') {
            $object['id_pemberi_kerja']         = $request['id_pemberi_kerja'];
            $object['id_bidang_pekerjaan_dpb']  = $request['id_bidang_pekerjaan'];
            $object['nama_pekerjaan']           = $request['nama_pekerjaan'];
            $object['tahun_anggaran']           = $request['tahun_anggaran'];
        }
        DB::table('daftar_proyek_berjalan')->where('id_dpb', $id)->update($object);


        $result = [
            'id_dpb'                => $id,
            'pic'                   => Session::get('id_users'),
            'tanggal_perubahan'     => now(),
            'keterangan_perubahan'  => $request['keterangan_perubahan']
        ];
        DB::table("data_perubahan_dpb")->insert($result);



        #Tambah Log User ==========================================
        $log = [
            'input_id'          => Session::get('id_users'),
            'id_dpb'            => $id,
            'aktivitas'         => 'Mengubah Daftar Proyek Berjalan (DPB)',
            'created_at'        => now()
        ];
        if ($dpb->jenis_pekerjaan_dpb != 'Lelang') {
            $log['id_branch_agency']         = $request['id_pemberi_kerja'];
        }
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================


        return redirect('dpb/' . Session::get('id_users'));
    }


    public function delete_dpb($id)
    {
        DB::table('termin_pembayaran_proyek_berjalan')->where('id_dpb', $id)->delete();
        DB::table('tenaga_ahli_proyek_berjalan')->where('id_dpb', $id)->delete();
        DB::table('objek_pekerjaan')->where('id_dpb', $id)->delete();
        DB::table("data_perubahan_dpb")->where('id_dpb', $id)->delete();
        DB::table("dpb_biaya")->where('id_dpb', $id)->delete();
        DB::table("daftar_proyek_berjalan")->where('id_dpb', $id)->delete();

        echo json_encode(array("status" => true));
    }


    public function add_termin(Request $request, $id)
    {
        $object = [
            'id_dpb'                    => $id,
            'nomor_termin'              => $request['nomor_termin'],
            'persentase_pembayaran'     => $request['persentase_pembayaran'],
            'harga_pembayaran'          => str_replace([".", ","], '', $request['harga_pembayaran']),
            'syarat_pembayaran'         => $request['syarat_pembayaran']
        ];
        DB::table("termin_pembayaran_proyek_berjalan")->insert($object);

        return response()->json();
    }

    public function delete_termin($id)
    {
        DB::table('termin_pembayaran_proyek_berjalan')->where('id_termin_pembayaran', $id)->delete();
        echo json_encode(array("status" => true));
    }




    public function add_tenaga_ahli(Request $request, $id)
    {
        $object = [
            'id_dpb'                    => $id,
            'id_tenaga_ahli'            => $request['id_tenaga_ahli'],
            'posisi_pekerjaan'          => $request['posisi_pekerjaan'],
            'is_lead'                   => $request['is_lead'],
            'status_kepegawaian'        => $request['status_kepegawaian'],
            'nomor_surat_referensi'     => $request['nomor_surat_referensi'],
        ];


        if ($request['is_lead'] == 1) {

            if (DB::table('tenaga_ahli_proyek_berjalan')->where('id_dpb', $id)->where('is_lead', 1)->count() >= 1) {

                return response()->json(['status' => 'error'], 500);
            } else {
                DB::table("tenaga_ahli_proyek_berjalan")->insert($object);
                $id_tg_ahli_proyek_berjalan = DB::getPdo()->lastInsertId();

                $obj = [
                    'id_tg_ahli_proyek_berjalan'    => $id_tg_ahli_proyek_berjalan,
                    'uraian_tugas'                  => $request['uraian_tugas'],
                ];
                DB::table("proyek_berjalan_uraian_tugas")->insert($obj);
                return response()->json();
            }
        } else {
            DB::table("tenaga_ahli_proyek_berjalan")->insert($object);
            $id_tg_ahli_proyek_berjalan = DB::getPdo()->lastInsertId();

            $obj = [
                'id_tg_ahli_proyek_berjalan'    => $id_tg_ahli_proyek_berjalan,
                'uraian_tugas'                  => $request['uraian_tugas'],
            ];
            DB::table("proyek_berjalan_uraian_tugas")->insert($obj);
            return response()->json();
        }
    }

    public function edit_tenaga_ahli(Request $request, $id)
    {
        $id_dpb = $request['id_dpb'];
        $object = [
            'id_tenaga_ahli'            => $request['id_tenaga_ahli'],
            'posisi_pekerjaan'          => $request['posisi_pekerjaan'],
            'is_lead'                   => $request['is_lead'],
            'status_kepegawaian'        => $request['status_kepegawaian'],
            'nomor_surat_referensi'     => $request['nomor_surat_referensi'],
        ];

        DB::table('tenaga_ahli_proyek_berjalan')->where('id_tg_ahli_proyek_berjalan', $id)->update($object);
        $obj = [
            'uraian_tugas'          => $request['uraian_tugas'],
        ];
        DB::table('proyek_berjalan_uraian_tugas')->where('id_tg_ahli_proyek_berjalan', $id)->update($obj);
        return response()->json();
    }

    public function delete_tenaga_ahli($id)
    {
        DB::table('proyek_berjalan_uraian_tugas')->where('id_tg_ahli_proyek_berjalan', $id)->delete();
        DB::table('tenaga_ahli_proyek_berjalan')->where('id_tg_ahli_proyek_berjalan', $id)->delete();
        echo json_encode(array("status" => true));
    }




    public function add_objek_pekerjaan(Request $request, $id)
    {
        $object = [
            'id_dpb'                    => $id,
            'organization'              => $request['organization']
        ];
        DB::table("objek_pekerjaan")->insert($object);

        // Alert::success('Success', 'Berhasil menambah data Objek Pekerjaan.');
        // return redirect('dpb/form-next-add/' . $id);

        return response()->json();
    }

    public function edit_objek_pekerjaan(Request $request, $id)
    {
        $id_dpb = $request['id_dpb'];
        $object = [
            'organization'              => $request['organization']
        ];
        DB::table('objek_pekerjaan')->where('id_objek_pekerjaan', $id)->update($object);

        return response()->json();
    }

    public function delete_objek_pekerjaan($id)
    {
        DB::table('objek_pekerjaan')->where('id_objek_pekerjaan', $id)->delete();
        echo json_encode(array("status" => true));
    }





    public function modal_tanggal_terima_kontrak($id)
    {
        $this->data = [];
        $this->data['dpb'] = DB::table('daftar_proyek_berjalan')->where('id_dpb', $id)->first();

        return view('dpb.modal_terima_kontrak', $this->data);
    }

    public function edit_tanggal_terima_kontrak(Request $request, $id)
    {
        $object = [
            'tanggal_kontrak_diterima'              => $request['tanggal_kontrak_diterima']
        ];
        DB::table('daftar_proyek_berjalan')->where('id_dpb', $id)->update($object);

        return response()->json();
    }

    public function modal_tanggal_terima_surat_referensi($id)
    {
        $this->data = [];
        $this->data['dpb'] = DB::table('daftar_proyek_berjalan')->where('id_dpb', $id)->first();

        return view('dpb.modal_terima_surat_referensi', $this->data);
    }

    public function edit_tanggal_terima_surat_referensi(Request $request, $id)
    {
        $object = [
            'surat_referensi'              => $request['surat_referensi']
        ];
        DB::table('daftar_proyek_berjalan')->where('id_dpb', $id)->update($object);

        return response()->json();
    }

    public function modal_info_perubahan($id)
    {
        $this->data = [];
        $riwayat_dpb = DB::table('data_perubahan_dpb')->where('id_dpb', $id);

        if ($riwayat_dpb->count() > 0) {
            $no = 1;
            $arr = [];
            foreach ($riwayat_dpb->get() as $row) {
                $pic = DB::table('users')->where('id', $row->pic)->first();
                $arr[] = '<tr>
                            <td>' . $no++ . '</td>
                            <td>' . $row->keterangan_perubahan . '</td>
                            <td>' . $row->tanggal_perubahan . '</td>
                            <td>' . $pic->first_name . ' ' . $pic->last_name . '</td>
                        </tr>';
            }

            $html = '
                <table class="table table-hover table-striped" style="width:100%;">
                    <tr>
                        <th width="5%">No</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>PIC</th>
                    </tr>
                    ' . implode("", $arr) . '
                </table>
            ';
        } else {
            $html = '<div class="text-center"><i>Belum ada data perubahan.</i></div>';
        }

        return $html;
    }


    public function publish(Request $request)
    {
        $id = $request->segment(3);
        $dpb = collect(DB::select("SELECT * FROM view_dpb WHERE id_dpb = $id"))->first();
        $this->data['dpb'] = $dpb;

        Mail::send('dpb.publish_email', $this->data, function ($message) use ($dpb) {
            $message->from('sim@kokek.com', 'SIM PT.KOKEK')
                ->to(['programmer@kokek.com'])
                ->subject('DPB ' . $dpb->nama_pekerjaan);
        });

        $object = [
            'is_publish_dpb'        => 1,
            'publish_at_dpb'        => now(),
            'count_publish_dpb'     => $dpb->jumlah_publish + 1,
        ];
        DB::table('daftar_proyek_berjalan')->where('id_dpb', $id)->update($object);

        echo json_encode(array("status" => true));
    }


    public function export(Request $request)
    {
        $this->data = [];
        $this->data['mulai'] = $request['mulai'];
        $this->data['sampai'] = $request['sampai'];
        $this->data['dpb'] = Dpb::where('tahun_dpb', $this->data['mulai'])
                            ->orWhere('tahun_dpb',  $this->data['sampai'])
                            ->orderBy('tahun_dpb', 'desc');


        $tahun = $this->data['mulai'] == $this->data['sampai'] ? $this->data['mulai'] : $this->data['mulai'] . '-' . $this->data['sampai'];
        $content = view('dpb.form_export_dpb', $this->data);
        $status = 200;
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="Dpb-Periode-' . $tahun . '.xls"',
        ];
        return response($content, $status, $headers);
    }
}
