<?php

namespace App\Http\Controllers;

use App\Models\Rup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Rencana Umum Pengadaan";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));



        // $this->data['data_rup'] = collect(Rup::get()->where('tahun_anggaran', '2023'));
        // date('Y')
        $rup = Rup::where('is_diproses_di_dil', 2)
            ->where('is_pekerjaan_prospek', null);
        // ->orderBy('created_at', 'desc');


        if ($request->ajax()) {
            return Datatables::of($rup)
                ->addIndexColumn()
                ->addColumn('paket', function ($row) {
                    $paket = '<span class="text-danger">' . $row->nama_pekerjaan . '</span><br><small>' . $row->nama_bidang_pekerjaan . '</small><br>

                    <div class="dropdown dropdown-inline">
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
                            <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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
                                        <span class="navi-text">Jadikan Prospek</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="javascript:void(0)" class="navi-link" onclick="jadikan_tidak_prospek(' . "'" . $row->id_rup . "', '" . $row->nama_pekerjaan . "'" . ')">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Jadikan Tidak Prospek</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/rup/form-edit-input/' . $row->id_rup . '" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Edit</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="javascript:void(0)" class="navi-link" onclick="delete_data(' . "'" . $row->id_rup . "', '" . $row->nama_pekerjaan . "'" . ')">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>';
                    return $paket;
                })
                // ->addColumn('pagu_rupiah', function ($row) {
                //     $pagu_rupiah = number_format($row->pagu,0,",",".");
                //     return $pagu_rupiah;
                // })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('pic') != '') {
                        $instance->where('pic', $request->get('pic'));
                    }
                    if ($request->get('bulan') != '') {
                        $instance->where('waktu_pemilihan_penyedia', 'like', '%' . $request->get('bulan') . '%');
                    }
                    if ($request->get('tahun') != '') {
                        $instance->where('tahun_anggaran', $request->get('tahun'));
                    } else {
                        $instance->where('tahun_anggaran', date('Y'));
                    }
                    if ($request->get('lokasi') != '') {
                        $instance->where('lokasi_pekerjaan', $request->get('lokasi'));
                    }

                    if ($request->get('pagu') != '') {
                        $instance->orderByRaw('CONVERT(pagu, SIGNED)' . $request->get('pagu'));
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                                ->orWhere('nama_organisasi', 'LIKE', "%$search%")
                                ->orWhere('id_sis_rup', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['paket', 'pagu_rupiah'])
                ->make(true);
        }


        return view('rup.index', $this->data);
    }


    public function download()
    {
        return response()->download(public_path('web\appsim\public/files/contoh_file_rup.xlsx'));
    }

    public function form_import()
    {
        $this->data = [];
        $this->data['title'] = "Import Data RUP";

        return view('rup/form_import', $this->data);
    }



    public function preview(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Import Preview";

        $tgl_sekarang = date('YmdHis');
        $nama_file_baru = 'data' . $tgl_sekarang . '.xlsx';

        if (is_file('temp/' . $nama_file_baru))
            unlink('temp/' . $nama_file_baru);

        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $tmp_file = $_FILES['file']['tmp_name'];

        if ($ext == "xlsx") {

            move_uploaded_file($tmp_file, 'temp/' . $nama_file_baru);
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load('temp/' . $nama_file_baru);
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);


            $numrow = 1;
            $jumlah_data = 0;
            $array_table = [];
            foreach ($sheet as $row) {
                $row_a = $row['A'];
                $row_b = $row['B'];
                $row_c = $row['C'];
                $row_d = $row['D'];
                $row_e = $row['E'];
                $row_f = $row['F'];
                $row_g = $row['G'];
                $row_h = $row['H'];
                $row_i = $row['I'];
                $row_j = $row['J'];
                $row_k = $row['K'];
                $row_l = $row['L'];

                if (
                    $row_a == ""
                    && $row_b == ""
                    && $row_c == ""
                    && $row_d == ""
                    && $row_e == ""
                    && $row_f == ""
                    && $row_g == ""
                    && $row_h == ""
                    && $row_i == ""
                    && $row_j == ""
                    && $row_k == ""
                    && $row_l == ""
                )
                    continue;

                if (DB::table("import_rencana_umum_pengadaan")->where('id_sis_rup', $row_l)->count() == 0) {
                    $jumlah_data++;
                    if ($numrow > 3) {
                        $array_table[] = '<tr>
                                                <td>' . $row_a . '</td>
                                                <td>' . $row_b . '</td>
                                                <td>' . str_replace([","], '.', $row['C']) . '</td>
                                                <td>' . $row_d . '</td>
                                                <td>' . $row_e . '</td>
                                                <td>' . $row_f . '</td>
                                                <td>' . $row_g . '</td>
                                                <td>' . $row_h . '</td>
                                                <td>' . $row_i . '</td>
                                                <td>' . $row_j . '</td>
                                                <td>' . $row_k . '</td>
                                                <td>' . $row_l . '</td>
                                            </tr>';
                    }
                }
                $numrow++;
            }

            if ($jumlah_data > 0) {
                $this->data['table'] = implode("", $array_table);
                $this->data['nama_file_baru'] = $nama_file_baru;

                return view('rup/form_preview', $this->data);
            } else {
                Alert::warning('Warning', 'Data RUP yang anda upload sudah ada pada database.');
                return redirect('rup/form-import/' . Session::get('id_users'));
            }
        } else {

            Alert::error('Error', 'File yang anda pilih bukan merupakan file excel');
            return redirect('rup/form-import/' . Session::get('id_users'));
            // exit();
        }
    }



    public function proses_import(Request $request)
    {

        $users = DB::table("users")->where('id', $request->segment(3))->first();

        $nama_file_baru = $request['namafile'];
        $path = 'temp/' . $nama_file_baru;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $result = array();
        $numrow = 1;
        foreach ($sheet as $row) {

            $row_a = $row['A'];
            $row_b = $row['B'];
            $row_c = $row['C'];
            $row_d = $row['D'];
            $row_e = $row['E'];
            $row_f = $row['F'];
            $row_g = $row['G'];
            $row_h = $row['H'];
            $row_i = $row['I'];
            $row_j = $row['J'];
            $row_k = $row['K'];
            $row_l = $row['L'];

            if (
                $row_a == ""
                && $row_b == ""
                && $row_c == ""
                && $row_d == ""
                && $row_e == ""
                && $row_f == ""
                && $row_g == ""
                && $row_h == ""
                && $row_i == ""
                && $row_j == ""
                && $row_k == ""
                && $row_l == ""
            )
                continue;

            if ($numrow > 3) { //insert dimulai baris ke 4


                // cek jika id sudah ada tidak perlu masuk variabel result
                if (DB::table("import_rencana_umum_pengadaan")->where('id_sis_rup', $row['L'])->count() == 0) {

                    $pecah = explode(" ", $row['H']);
                    $jumlah_pecah = count($pecah);
                    if ($jumlah_pecah > 1) {
                        $tahun_anggaran = $pecah[1];
                    } else {
                        $pecah = explode("-", $row['H']);
                        $tahun_anggaran = $pecah[1];
                    }

                    $object[] = '';
                    $result = [
                        'id_rup'                    => Str::uuid(),
                        'nama_pekerjaan'            => $row['B'],
                        'pagu'                      => str_replace([".", ","], '', $row['C']),
                        'nama_jenis_pengadaan'      => $row['D'],
                        'nama_jenis_produk_rup'     => $row['E'],
                        'nama_jenis_usaha'          => $row['F'],
                        'nama_metode_pengadaan'     => $row['G'],
                        'waktu_pemilihan_penyedia'  => $row['H'],
                        'nama_instansi'             => $row['I'],
                        'nama_organisasi'           => $row['J'],
                        'lokasi_pekerjaan'          => $row['K'],
                        'id_sis_rup'                => $row['L'],
                        'nama_bidang_pekerjaan'     => null,
                        'tahun_anggaran'            => $tahun_anggaran,
                        'created_at'                => now(),
                        'is_sirup'                  => '1',
                        'is_import'                 => '1',
                        'is_pekerjaan_prospek'      => null,
                        'pic'                       => $users->first_name . ' ' . $users->last_name,
                        'input_id'                  => $request->segment(3)
                    ];

                    DB::table("import_rencana_umum_pengadaan")->insert($result);
                }
            }

            $numrow++;
        }

        // Alert::success('success', 'success');
        // return redirect('rup/' . Session::get('id_users'));

        return response()->json();
    }


    public function form_add()
    {
        $this->data = [];
        $this->data['title'] = "Tambah Data RUP";

        return view('rup/form_add', $this->data);
    }

    public function proses_add(Request $request)
    {
        $this->data = [];
        $object = array(
            'id_rup'                => Str::uuid(),
            'id_sis_rup'            => $request['id_sis_rup'],
            'is_sirup'              => 1,
            'id_jenis_produk_rup'    => $request['id_jenis_produk_rup'],
            'id_jenis_usaha'        => $request['id_jenis_usaha'],
            'organization'          => $request['id_branch_agency'],
            'id_bidang_pekerjaan'   => $request['id_bidang_pekerjaan'],
            'nama_pekerjaan'        => $request['nama_pekerjaan'],
            'tahun_anggaran'        => $request['tahun_anggaran'],
            'id_jenis_pengadaan'    => $request['id_kategori_lelang'],
            'pagu'                  => str_replace([".", ","], '', $request['pagu']),
            'id_pemilihan_penyedia' => $request['id_metode_pengadaan'],
            'bulan_waktu_pemilihan' => $request['bulan_waktu_pemilihan'],
            'tahun_waktu_pemilihan' => $request['tahun_waktu_pemilihan'],
            'lokasi_pekerjaan'      => $request['lokasi_pekerjaan'],
            'is_import'             => '0',
            'created_at'            => now(),
            'input_id'              => $request->segment(3),
        );
        DB::table("rencana_umum_pengadaan")->insert($object);

        Alert::success('Success', 'Berhasil Menambah Data');
        return redirect('rup/' . $request->segment(3));
    }



    public function delete_data($id)
    {

        if (DB::table('import_rencana_umum_pengadaan')->where('id_rup', $id)->count() > 0) {
            DB::table('import_rencana_umum_pengadaan')->where('id_rup', $id)->delete();
        } else {
            DB::table('rencana_umum_pengadaan')->where('id_rup', $id)->delete();
        }
        echo json_encode(array("status" => true));
    }


    public function form_edit_input(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Edit Data RUP";

        $rup = DB::table("rencana_umum_pengadaan")->where('id_rup', $request->segment(3));
        if ($rup->count() == 0) {
            return redirect('rup/form-edit-import/' . $request->segment(3));
        }

        $this->data['rup'] = $rup->first();
        return view('rup/form_edit_input', $this->data);
    }

    public function proses_edit_input(Request $request)
    {
        $this->data = [];
        $object = array(
            'id_jenis_produk_rup'    => $request['id_jenis_produk_rup'],
            'id_jenis_usaha'        => $request['id_jenis_usaha'],
            'organization'          => $request['id_branch_agency'],
            'id_bidang_pekerjaan'   => $request['id_bidang_pekerjaan'],
            'nama_pekerjaan'        => $request['nama_pekerjaan'],
            'tahun_anggaran'        => $request['tahun_anggaran'],
            'id_jenis_pengadaan'    => $request['id_kategori_lelang'],
            'pagu'                  => str_replace([".", ","], '', $request['pagu']),
            'id_pemilihan_penyedia' => $request['id_metode_pengadaan'],
            'bulan_waktu_pemilihan' => $request['bulan_waktu_pemilihan'],
            'tahun_waktu_pemilihan' => $request['tahun_waktu_pemilihan'],
            'lokasi_pekerjaan'      => $request['lokasi_pekerjaan'],
        );
        DB::table('rencana_umum_pengadaan')->where('id_rup', $request->segment(3))->update($object);

        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('rup/' . Session::get('id_users'));
    }


    public function form_edit_import(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Edit Data RUP";
        $this->data['rup'] = DB::table("import_rencana_umum_pengadaan")->where('id_rup', $request->segment(3))->first();

        return view('rup/form_edit_import', $this->data);
    }

    public function proses_edit_import(Request $request)
    {
        $this->data = [];
        $rup = DB::table("import_rencana_umum_pengadaan")->where('id_rup', $request->segment(3))->first();
        $object = array(
            'nama_pekerjaan'            => $request['nama_pekerjaan'],
            'pagu'                      => str_replace([".", ","], '', $request['pagu']),
            'nama_jenis_pengadaan'      => $request['nama_jenis_pengadaan'],
            'nama_metode_pengadaan'     => $request['nama_metode_pengadaan'],
            'waktu_pemilihan_penyedia'  => $request['waktu_pemilihan_penyedia'],
            'nama_instansi'             => $request['nama_instansi'],
            'nama_organisasi'           => $request['nama_organisasi'],
            'lokasi_pekerjaan'          => $request['lokasi_pekerjaan'],
            'nama_bidang_pekerjaan'     => $request['nama_bidang_pekerjaan'],
            'tahun_anggaran'            => $request['tahun_anggaran'],
            'alamat_organisasi'         => $request['alamat_organisasi'],
        );
        DB::table('import_rencana_umum_pengadaan')->where('id_rup', $request->segment(3))->update($object);

        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('rup/' . Session::get('id_users'));
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


    public function ubah_ke_tidak_prospek($id)
    {
        // Cek data input atau import
        $query = DB::table('view_rencana_umum_pengadaan')->where('id_rup', $id)->first();

        if ($query->is_import == 1) {
            DB::table('import_rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => 1, 'updated_at' => now()]);
        } else {

            DB::table('rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => 1, 'updated_at' => now()]);
        }

        echo json_encode(array("status" => true));
    }
}
