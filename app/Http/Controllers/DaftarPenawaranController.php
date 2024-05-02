<?php

namespace App\Http\Controllers;

use App\Models\Rup;
use App\Mail\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DaftarPenawaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DaftarPenawaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Daftar Penawaran";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));



        // $this->data['data_rup'] = collect(Rup::get()->where('tahun_anggaran', '2023'));
        // date('Y')
        $DaftarPenawaran = DaftarPenawaran::orderBy('nilai_hps', 'asc')->orderBy('id_dil', 'desc');

        if ($request->ajax()) {
            return Datatables::of($DaftarPenawaran)
                ->addIndexColumn()
                ->addColumn('paket', function ($row) {


                    #cek jadwal Penjelasan Dokumen Prakualifikasi sudah terisi apa belum
                    $jadwal_aanwizing = DB::table('tahap_lelang')->where('id_dil', $row->id_dil)->where('id_data_tahapan_lelang', 4);

                    #cek data pekerjaan sudah lengkap atau belum
                    if ($jadwal_aanwizing->count() > 0) {

                        if ($jadwal_aanwizing->first()->waktu_mulai_tahap_lelang != '' || $jadwal_aanwizing->first()->waktu_sampai_tahap_lelang != '') {
                            $link_aanwizing = 'href="/daftar-penawaran/form-aanwizing/' . $row->id_dil . '"';
                        } else {
                            $link_aanwizing = 'href="javascript:void(0)" onclick="aanwizing(' . $row->id_dil . ')"';
                        }
                    } else {
                        $link_aanwizing = 'href="javascript:void(0)" onclick="lengkapi_data(' . $row->id_dil . ')"';
                    }

                    $link_hasil_lelang = $row->nilai_hps != '' ? 'href="/daftar-penawaran/form-hasil-lelang/' . $row->id_dil . '"' : 'href="javascript:void(0)" onclick="lengkapi_data(' . $row->id_dil . ')"';

                    $paket = '<b class="text-danger">' . $row->nama_pekerjaan . '</b><br>
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
                                    <a class="navi-link" data-toggle="modal" data-target="#add-surat">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Surat</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/daftar-penawaran/form-jadwal-lelang/' . $row->id_dil . '" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Jadwal Lelang</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a ' . $link_aanwizing . ' class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Aanwizing</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a ' . $link_hasil_lelang . ' class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Ubah/Publish Hasil DIL</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="/daftar-penawaran/form-sanggahan/' . $row->id_dil . '" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Sanggahan</span>
                                    </a>
                                </li>

                                <li class="navi-item">
                                    <a href="/daftar-penawaran/form-edit/' . $row->id_dil . '" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Edit</span>
                                    </a>
                                </li>
                                
                                <li class="navi-item">
                                    <a href="javascript:void(0)" class="navi-link" onclick="delete_data(' . "'" . $row->id_dil . "', '" . $row->nama_pekerjaan . "'" . ')">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Delete</span>
                                    </a>
                                </li>
                            
                            </ul>
                        </div>
                    </div>';
                    return $paket;
                })
                ->addColumn('nama_pemberi_kerja', function ($row) {

                    if ($row->pemberi_kerja == $row->pemberi_kerja_parent) {
                        $pemberi_kerja = $row->pemberi_kerja;
                    } else {
                        $pemberi_kerja = $row->pemberi_kerja . ' ' . $row->pemberi_kerja_parent;
                    }
                    return $pemberi_kerja;
                })
                ->addColumn('status', function ($row) {

                    $status = $this->status_lelang($row);
                    return $status;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('tahun') != '') {
                        $instance->where('tahun_anggaran', $request->get('tahun'));
                    } else {
                        $instance->where('tahun_anggaran', date('Y'));
                    }

                    if ($request->get('status_lelang') != '') {
                        $instance->where('hasil_lelang', $request->get('status_lelang'));
                    }
                    if ($request->get('id_is_sirup') != '') {
                        $instance->where('id_is_sirup', $request->get('id_is_sirup'));
                    }
                    if ($request->get('pagu_min') != '') {
                        $instance->where('nilai_pekerjaan', '>=', str_replace([".", ","], '', $request->get('pagu_min')));
                    }
                    if ($request->get('pagu_max') != '') {
                        $instance->where('nilai_pekerjaan', '<=', str_replace([".", ","], '', $request->get('pagu_max')));
                    }

                    if ($request->get('nilai_hps_min') != '') {
                        $instance->where('nilai_hps', '>=', str_replace([".", ","], '', $request->get('nilai_hps_min')));
                    }

                    if ($request->get('nilai_hps_max') != '') {
                        $instance->where('nilai_hps', '<=', str_replace([".", ","], '', $request->get('nilai_hps_max')));
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                                ->orWhere('pemberi_kerja', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('metode', function ($row) {
                    $metode = '<span><b>Pengadaan :</b> ' . $row->metode_pengadaan . '</span><br>
                                <span><b>Kualifikasi :</b> ' . $row->metode_kualifikasi . '</span><br>
                                <span><b>Dokumen :</b> ' . $row->metode_dokumen . '</span><br>
                                <span><b>Evaluasi :</b> ' . $row->metode_evaluasi . '</span>';


                    return $metode;
                })
                ->rawColumns(['paket', 'nama_pemberi_kerja', 'status', 'metode'])
                ->make(true);
        }


        return view('daftar_penawaran.index', $this->data);
    }

    public function form_add_dengan_rup()
    {
        $this->data = [];
        $this->data['title'] = "Tambah Daftar Penawaran";
        $this->data['users'] = DB::table('users')->where('id', Session::get('id_users'))->first();
        // var_dump(Session::get('id_users'));

        return view('daftar_penawaran.add_dengan_rup', $this->data);
    }


    public function cari_id_rup($id = 0)
    {
        $data = Rup::where('id_rup', $id)->first();
        echo json_encode($data);
    }

    public function add_dengan_rup(Request $request)
    {
        $object = [
            'id_kategori_dil'               => 1,
            'id_rup'                        => $request['id_rup'],
            'pembebanan_tahun_anggaran'     => $request['pembebanan_tahun_anggaran'],
            'id_metode_kualifikasi'         => $request['id_metode_kualifikasi'],
            'id_metode_dokumen'             => $request['id_metode_dokumen'],
            'id_metode_evaluasi'            => $request['id_metode_evaluasi'],
            'nilai_hps'                     => str_replace([".", ","], '', $request['nilai_hps']),
            'keterangan_lelang'             => $request['keterangan'],
            'input_id'                      => Session::get('id_users'),
            'created_at'                    => now(),
            'pic_dil'                       => $request['pic'],
            'id_pokja'                      => $request['pokja']
        ];
        DB::table("daftar_informasi_lelang")->insert($object);
        $insert_id = DB::getPdo()->lastInsertId();


        # INSERT TAHAP LELANG
        foreach (DB::table('data_tahapan_lelang')->where('id_metode_kualifikasi', $request['id_metode_kualifikasi'])->get() as $row) {
            DB::select("INSERT INTO tahap_lelang (id_dil, id_data_tahapan_lelang)
            VALUES ($insert_id, $row->id_data_tahapan_lelang)");
        }


        # HASIL LELANG 
        $value = [
            'id_dil'            => $insert_id,
            'status_lelang'     => 7,
        ];
        DB::table("hasil_lelang")->insert($value);


        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_dil'            => $insert_id,
            'aktivitas'         => 'Menambah Daftar Penawaran',
            'created_at'        => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================


        Alert::success('Success', 'Berhasil Menambah Data DIL');
        return redirect('daftar-penawaran/' . Session::get('id_users'));
    }


    public function form_add_tanpa_rup()
    {
        $this->data = [];
        $this->data['title'] = "Tambah Daftar Penawaran";
        $this->data['users'] = DB::table('users')->where('id', Session::get('id_users'))->first();
        // var_dump(Session::get('id_users'));

        return view('daftar_penawaran.add_tanpa_rup', $this->data);
    }


    public function add_tanpa_rup(Request $request)
    {
        $id_rup = Str::uuid();
        $object_rup = array(
            'id_rup'                => $id_rup,
            'is_sirup'              => 0,
            'organization'          => $request['id_branch_agency'],
            'nama_pekerjaan'        => $request['nama_pekerjaan'],
            'tahun_anggaran'        => $request['tahun_anggaran'],
            'id_jenis_pengadaan'    => $request['id_kategori_lelang'],
            'pagu'                  => str_replace([".", ","], '', $request['pagu']),
            'bulan_waktu_pemilihan' => $request['bulan_waktu_pemilihan'],
            'tahun_waktu_pemilihan' => $request['tahun_waktu_pemilihan'],
            'id_pemilihan_penyedia' => $request['id_metode_pengadaan'],
            'id_bidang_pekerjaan'   => $request['id_bidang_pekerjaan'],
            'is_import'             => 0,
            'created_at'            => now(),
            'input_id'              => Session::get('id_users')
        );
        DB::table("rencana_umum_pengadaan")->insert($object_rup);


        $object_dil = [
            'id_kategori_dil'               => 1,
            'id_rup'                        => $id_rup,
            'pembebanan_tahun_anggaran'     => $request['pembebanan_tahun_anggaran'],
            'id_metode_kualifikasi'         => $request['id_metode_kualifikasi'],
            'id_metode_dokumen'             => $request['id_metode_dokumen'],
            'id_metode_evaluasi'            => $request['id_metode_evaluasi'],
            'nilai_hps'                     => str_replace([".", ","], '', $request['nilai_hps']),
            'keterangan_lelang'             => $request['keterangan'],
            'input_id'                      => Session::get('id_users'),
            'created_at'                    => now(),
            'pic_dil'                       => $request['pic'],
            'id_pokja'                      => $request['pokja']
        ];
        DB::table("daftar_informasi_lelang")->insert($object_dil);
        $insert_id = DB::getPdo()->lastInsertId();


        # INSERT TAHAP LELANG
        foreach (DB::table('data_tahapan_lelang')->where('id_metode_kualifikasi', $request['id_metode_kualifikasi'])->get() as $row) {
            DB::select("INSERT INTO tahap_lelang (id_dil, id_data_tahapan_lelang)
            VALUES ($insert_id, $row->id_data_tahapan_lelang)");
        }


        # HASIL LELANG 
        $value = [
            'id_dil'            => $insert_id,
            'status_lelang'     => 7,
        ];
        DB::table("hasil_lelang")->insert($value);



        #Tambah Log User ==========================================
         $log = [
            'input_id'           => Session::get('id_users'),
            'id_branch_agency'  => $request['id_branch_agency'],
            'id_rup'            => $id_rup,
            'id_dil'            => $insert_id,
            'aktivitas'         => 'Menambah Rencana Umum Pengadaan (RUP) dan Daftar Penawaran',
            'created_at'        => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================


        Alert::success('Success', 'Berhasil Menambah Data DIL');
        return redirect('daftar-penawaran/' . Session::get('id_users'));
    }


    public function form_edit(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Ubah Daftar Penawaran";
        $this->data['users'] = DB::table('users')->where('id', Session::get('id_users'))->first();
        $this->data['dil'] = DaftarPenawaran::where('id_dil', $request->segment(3))->first();
        // var_dump($this->data['dil']);

        if ($this->data['dil']->is_import == 0) {

            return view('daftar_penawaran.edit_input', $this->data);
        } else {
            return view('daftar_penawaran.edit_import', $this->data);
        }
    }

    public function proses_edit(Request $request)
    {
        $dil = DaftarPenawaran::where('id_dil', $request->segment(3))->first();

        # Cek data DIL dari RUP atau tidak
        if ($dil->is_import == 0) {
            $object_rup = array(
                'organization'          => $request['id_branch_agency'],
                'id_bidang_pekerjaan'   => $request['id_bidang_pekerjaan'],
                'nama_pekerjaan'        => $request['nama_pekerjaan'],
                'tahun_anggaran'        => $request['tahun_anggaran'],
                'id_jenis_pengadaan'    => $request['id_kategori_lelang'],
                'pagu'                  => str_replace([".", ","], '', $request['pagu']),
                'id_pemilihan_penyedia' => $request['id_metode_pengadaan'],
            );
            DB::table('rencana_umum_pengadaan')->where('id_rup', $dil->id_rup)->update($object_rup);
        }


        #jika pindahan dari prospek
        $id_metode_kualifikasi = $request['id_metode_kualifikasi'];
        if ($dil->id_metode_kualifikasi == '' && $id_metode_kualifikasi != '') {

            foreach (DB::table('data_tahapan_lelang')->where('id_metode_kualifikasi', $id_metode_kualifikasi)->get() as $row) {
                DB::select("INSERT INTO tahap_lelang (id_dil, id_data_tahapan_lelang) VALUES ($dil->id_dil, $row->id_data_tahapan_lelang)");
            }
        }


        $object_dil = [
            'pembebanan_tahun_anggaran'     => $request['pembebanan_tahun_anggaran'],
            'id_metode_kualifikasi'         => $id_metode_kualifikasi,
            'id_metode_dokumen'             => $request['id_metode_dokumen'],
            'id_metode_evaluasi'            => $request['id_metode_evaluasi'],
            'nilai_hps'                     => str_replace([".", ","], '', $request['nilai_hps']),
            'keterangan_lelang'             => $request['keterangan'],
            'updated_at'                    => now(),
            'pic_dil'                       => $request['pic'],
            'id_pokja'                      => $request['pokja']
        ];
        DB::table('daftar_informasi_lelang')->where('id_dil', $dil->id_dil)->update($object_dil);


        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_dil'            => $dil->id_dil,
            'aktivitas'         => 'Mengubah Daftar Penawaran',
            'created_at'        => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================
        

        Alert::success('Success', 'Berhasil Mengubah Data DIL');
        return redirect('daftar-penawaran/' . Session::get('id_users'));
    }

    public function delete_data($id)
    {
        if (DB::table('daftar_proyek_berjalan')->where('id_dil', $id)->count() > 0) {
            echo json_encode(array("status" => false));
        } else {

            # JIKA DIL INPUT MANUAL
            $data_dil = DB::table('view_data_dil_marketing')->where('id_dil', $id)->first();
            if ($data_dil->id_is_sirup == 0) {
                DB::table('rencana_umum_pengadaan')->where('id_rup', $data_dil->id_rup)->delete();
            }

            DB::table('tahap_lelang')->where('id_dil', $id)->delete();
            DB::table('hasil_lelang')->where('id_dil', $id)->delete();
            DB::table('daftar_informasi_lelang')->where('id_dil', $id)->delete();

            echo json_encode(array("status" => true));
        }
    }

    public function form_hasil_lelang(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Ubah Hasil Lelang";
        $this->data['users'] = DB::table('users')->where('id', Session::get('id_users'))->first();
        $this->data['dil'] = DaftarPenawaran::where('id_dil', $request->segment(3))->first();
        $dil = $this->data['dil'];
        $this->data['hasil_lelang'] = DB::table('hasil_lelang')->where('id_dil', $request->segment(3))->first();
        $this->data['status'] = $this->status_lelang($dil);

        return view('daftar_penawaran.hasil_lelang', $this->data);
    }

    public function ubah_hasil_lelang(Request $request)
    {
        if ($request['status'] == 1) {
            $object = [
                'nilai_penawaran'               => str_replace([".", ","], '', $request['nilai_penawaran']),
                'nilai_kontrak'                 => str_replace([".", ","], '', $request['nilai_kontrak']),
                'id_kompetitor_pemenang'        => null,
                'keterangan_alasan'             => null,
                'penyebab_tidak_lolos'          => null,
                'keterangan_penyebab'           => null,
                'status_sanggahan'              => null,
            ];
        } elseif ($request['status'] == 2) {
            $object = [
                'nilai_penawaran'               => null,
                'nilai_kontrak'                 => null,
                'id_kompetitor_pemenang'        => $request['id_kompetitor_pemenang'],
                'keterangan_alasan'             => $request['keterangan_alasan_kalah'],
                'penyebab_tidak_lolos'          => $request['penyebab_tidak_lolos_kalah'],
                'keterangan_penyebab'           => $request['keterangan_penyebab_kalah'],
                'status_sanggahan'              => $request['status_sanggahan_kalah'],
            ];
        } elseif ($request['status'] == 3) {
            $object = [
                'nilai_penawaran'               => null,
                'nilai_kontrak'                 => null,
                'id_kompetitor_pemenang'        => null,
                'keterangan_alasan'             => $request['keterangan_alasan_mundur'],
                'penyebab_tidak_lolos'          => null,
                'keterangan_penyebab'           => null,
                'status_sanggahan'              => null,
            ];
        } elseif ($request['status'] == 4) {
            $object = [
                'nilai_penawaran'               => null,
                'nilai_kontrak'                 => null,
                'id_kompetitor_pemenang'        => null,
                'keterangan_alasan'             => $request['keterangan_alasan_gugur'],
                'penyebab_tidak_lolos'          => $request['penyebab_tidak_lolos_gugur'],
                'keterangan_penyebab'           => $request['keterangan_penyebab_gugur'],
                'status_sanggahan'              => $request['status_sanggahan_gugur'],
            ];
        } elseif ($request['status'] == 5) {
            $object = [
                'nilai_penawaran'               => null,
                'nilai_kontrak'                 => null,
                'id_kompetitor_pemenang'        => null,
                'keterangan_alasan'             => $request['keterangan_alasan_batal'],
                'penyebab_tidak_lolos'          => null,
                'keterangan_penyebab'           => null,
                'status_sanggahan'              => null,
            ];
        } elseif ($request['status'] == 6) {
            $object = [
                'nilai_penawaran'               => null,
                'nilai_kontrak'                 => null,
                'id_kompetitor_pemenang'        => null,
                'keterangan_alasan'             => $request['keterangan_alasan_tidak_lulus'],
                'penyebab_tidak_lolos'          => $request['penyebab_tidak_lolos_tidak_lulus'],
                'keterangan_penyebab'           => $request['keterangan_penyebab_tidak_lulus'],
                'status_sanggahan'              => $request['status_sanggahan_tidak_lulus'],
            ];
        }
        $object['status_lelang'] = $request['status'];
        $object['updated_at'] = now();
        $object['update_id'] = Session::get('id_users');


        // var_dump($object);
        DB::table('hasil_lelang')->where('id_dil', $request->segment(3))->update($object);



        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_dil'            => $request->segment(3),
            'aktivitas'         => 'Mengubah Hasil Lelang',
            'created_at'        => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================



        Alert::success('Success', 'Berhasil Mengubah Hasil Lelang');
        return redirect('daftar-penawaran/form-hasil-lelang/' . $request->segment(3));
    }

    public function form_jadwal_lelang(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Jadwal Lelang";
        $this->data['users'] = DB::table('users')->where('id', Session::get('id_users'))->first();
        $this->data['dil'] = DaftarPenawaran::where('id_dil', $request->segment(3))->first();

        return view('daftar_penawaran.jadwal_lelang', $this->data);
    }

    public function ubah_jadwal_lelang(Request $request)
    {
        $object = [
            'waktu_mulai_tahap_lelang'  => str_replace('T', ' ', $request['waktu_mulai_tahap_lelang']),
            'waktu_sampai_tahap_lelang' =>  str_replace('T', ' ', $request['waktu_sampai_tahap_lelang']),
        ];

        DB::table('tahap_lelang')->where('id_tahap_lelang', $request['id_tahap_lelang'])->update($object);
        Alert::success('Success', 'Berhasil Mengubah Hasil Lelang');
        return redirect('daftar-penawaran/form-jadwal-lelang/' . $request->segment(3));
    }

    public function publish(Request $request)
    {
        $dil = DB::table('data_dil_marketing')->where('id_dil', $request->segment(3))->first();
        $this->data['dil'] = $dil;
        $this->data['status'] = $this->status_lelang($this->data['dil']);


        Mail::send('daftar_penawaran.form_email', $this->data, function ($message) use ($dil) {
            $message->from('sim@kokek.com', 'SIM PT.KOKEK')
                ->to('programmer@kokek.com')
                ->subject('Hasil Lelang ' . $dil->nama_pekerjaan);
        });


        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_dil'            => $dil->id_dil,
            'aktivitas'         => 'Mempublish Hasil Lelang',
            'created_at'        => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================

        // ->to('programmer@kokek.com')->cc('lefi.andri@kokek.com')


        echo json_encode(array("status" => true));
        // return view('daftar_penawaran.form_email', $this->data);
    }

    public function status_lelang($row)
    {
        switch ($row->hasil_lelang) {
            case 0:
                $status = '<h5><span class="badge badge-secondary"><i class="fas fa-question-circle text-white"></i> ' . $row->nama_hasil_lelang . '</span></h5>';
                break;
            case 1: // Menang
                $status = '<h5><span class="badge badge-success"><i class="fas fa-check-circle text-white"></i> ' . $row->nama_hasil_lelang . '</span></h5>
                            <b>Nilai Penawaran</b> : ' . number_format($row->nilai_penawaran, 0, ".", ".") . ' <br>
                            <div><b>Nilai Kontrak</b> : ' . number_format($row->nilai_kontrak, 0, ".", ".") . '</div>';
                break;
            case 2: // Kalah
                $status = '<b><h5><span class="badge badge-danger"><i class="fas fa-times-circle text-white"></i> ' . $row->nama_hasil_lelang . '</b></h5></span> 
                            <br><b>Pemenang</b> : ' . $row->kompetitor_pemenang . ' 
                            <br><b>Alasan</b> : ' . $row->keterangan_alasan . '
                            <br><b>Penyebab tidak lolos Pra</b> : ' . $row->penyebab_tidak_lolos . '
                            <br><b>Keterangan tidak lolos Pra</b> : ' . $row->keterangan_penyebab . '
                            <br><b>Melakukan Sanggahan</b> : ' . $row->status_sanggahan;
                break;
            case 3: // Mundur
                $status = '<b><h5><span class="badge badge-warning"><i class="fas fa-exclamation-circle text-white"></i> ' . $row->nama_hasil_lelang . '</b></h5></span> <br>
                            <b>Alasan</b> : ' . $row->keterangan_alasan;
                break;
            case 4: // Gugur
                $status = '<b><h5><span class="badge badge-warning"><i class="fas fa-exclamation-circle text-white"></i> ' . $row->nama_hasil_lelang . '</b></h5></span> 
                            <br><b>Alasan</b> : ' . $row->keterangan_alasan . '
                            <br><b>Penyebab tidak lolos Pra</b> : ' . $row->penyebab_tidak_lolos . '
                            <br><b>Keterangan tidak lolos Pra</b> : ' . $row->keterangan_penyebab . '
                            <br><b>Melakukan Sanggahan</b> : ' . $row->status_sanggahan;
                break;
            case 5: // Lelang Dibatalkan
                $status = '<b><h5><span class="badge badge-dark text-white"><i class="fas fa-exclamation-circle text-white"></i> ' . $row->nama_hasil_lelang . '</h5></b>Alasan : ' . $row->keterangan_alasan;
                break;
            case 6: // Tidak Lulus Prakualifikasi
                $status = '<b><h5><span class="badge badge-dark text-white"><i class="fas fa-exclamation-circle text-white"></i> ' . $row->nama_hasil_lelang . '</h5></b><br>
                            <b>Alasan</b> : ' . $row->keterangan_alasan . '
                            <br><b>Penyebab tidak lolos Pra</b> : ' . $row->penyebab_tidak_lolos . '
                            <br><b>Keterangan tidak lolos Pra</b> : ' . $row->keterangan_penyebab . '
                            <br><b>Melakukan Sanggahan</b> : ' . $row->status_sanggahan;
                break;
            case 7:
                $status = '<b><h5><span class="badge badge-dark text-white"><i class="fas fa-exclamation-circle text-white"></i> ' . $row->nama_hasil_lelang . '</h5></b>';
                break;
        }
        return $status;
    }


    public function add_proposal(Request $request)
    {
        $object = [
            'id_jenis_proposal'         => $request['id_jenis_proposal'],
            'id_bidang_pekerjaan'       => $request['id_bidang_pekerjaan'],
            'nama_master_proposal'      => $request['nama_master_proposal'],
            'created_at'                => date('Y-m-d H:i:s')
        ];
        DB::table("master_proposal")->insert($object);
        $insert_id = DB::getPdo()->lastInsertId();
        // var_dump($object);

        return redirect('surat-proposal/form-add/' . $request['id_jenis_proposal'] . '/' . $insert_id);
    }


    public function form_aanwizing(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Aanwizing";
        $this->data['users'] = DB::table('users')->where('id', Session::get('id_users'))->first();
        $this->data['dil'] = DaftarPenawaran::where('id_dil', $request->segment(3))->first();
        $dil = $this->data['dil'];
        $this->data['hasil_lelang'] = DB::table('hasil_lelang')->where('id_dil', $request->segment(3))->first();
        $this->data['status'] = $this->status_lelang($dil);

        return view('daftar_penawaran.aanwizing', $this->data);
    }


    public function publish_aanwizing(Request $request)
    {
        $id_dil = $request->segment(3);

        $object = [
            'jenis_kontrak'         => $request['jenis_kontrak'],
            'nilai_batas_evaluasi'  => $request['nilai_batas_evaluasi'],
            'bobot_teknis'          => $request['bobot_teknis'],
            'bobot_biaya'           => $request['bobot_biaya'],
            'uraian_aanwizing'      => $request['uraian_aanwizing'],
            'is_publish_aanwizing'  => 1
        ];
        DB::table('daftar_informasi_lelang')->where('id_dil', $id_dil)->update($object);

        $dil = DB::table('data_dil_marketing')->where('id_dil', $id_dil)->first();
        $this->data['dil'] = $dil;

        Mail::send('daftar_penawaran.aanwizing_email', $this->data, function ($message) use ($dil) {
            $message->from('sim@kokek.com', 'SIM PT.KOKEK')
                ->to('programmer@kokek.com')
                ->subject('Aanwizing ' . $dil->nama_pekerjaan);
        });


        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_dil'            => $id_dil,
            'aktivitas'         => 'Mempublish Aanwizing',
            'created_at'        => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================
        

        return response()->json();

        // return view('daftar_penawaran.aanwizing_email', $this->data);
    }


    public function form_sanggahan(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Form Sanggahan";
        $this->data['users'] = DB::table('users')->where('id', Session::get('id_users'))->first();
        $this->data['dil'] = DaftarPenawaran::where('id_dil', $request->segment(3))->first();
        $dil = $this->data['dil'];
        $this->data['hasil_lelang'] = DB::table('hasil_lelang')->where('id_dil', $request->segment(3))->first();
        $this->data['status'] = $this->status_lelang($dil);

        return view('daftar_penawaran.form_sanggahan', $this->data);
    }
}
