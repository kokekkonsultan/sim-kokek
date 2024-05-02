<?php

namespace App\Http\Controllers;

use App\Models\MasterUnit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MasterUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Master Data Unit Organisasi";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));



        $MasterUnit = MasterUnit::kode();
        if ($request->ajax()) {
            return Datatables::of($MasterUnit)
                ->addIndexColumn()
                ->addColumn('nama_organisasi', function ($row) {

                    // $nama_organisasi = '<div class="checkbox-list"><label class="checkbox"><input type="checkbox" name="id_branch_agency[]" value="' . $row->id_branch_agency . '" class="child"><span></span>' . $row->nama_organisasi_utama . '</label></div>';

                    $data = DB::table('log_aktivitas_user')->where('id_branch_agency', $row->id_branch_agency)->count();
                    $btn_aktivitas = '<a class="badge badge-info font-weight-bold" target="_blank" href="/master-organisasi/log-aktivitas/' . $row->id_branch_agency . '" title="Aktivitas Organisasi">' . $data . ' Aktivitas</a>';


                    $nama_organisasi = $row->nama_organisasi_utama . '<hr>' . $btn_aktivitas;
                    return $nama_organisasi;
                })
                ->addColumn('nama_organisasi_parent', function ($row) {
                    $nama_organisasi_parent = $row->nama_turunan_organisasi . '<br><span class="text-primary">' . $row->nama_parent_data_unit . '</span>';
                    return $nama_organisasi_parent;
                })
                ->addColumn('btn_kop', function ($row) {


                    $arr_kop = [];
                    $no = 1;
                    foreach (collect(DB::select("SELECT *,
                    (SELECT nama_surat_ditujukan FROM surat_ditujukan WHERE organisasi_surat_ditujukan.id_surat_ditujukan = surat_ditujukan.id) AS nama_surat_ditujukan
                    
                    FROM organisasi_surat_ditujukan
                    JOIN view_organisasi ON organisasi_surat_ditujukan.id_branch_agency = view_organisasi.id_branch_agency
                    WHERE organisasi_surat_ditujukan.id_branch_agency = $row->id_branch_agency")) as $value) {

                        $nama_organisasi = $value->nama_organisasi_utama != '' ? $value->nama_organisasi_utama : '';
                        $alamat_organisasi = $value->alamat_organisasi != '' ? '<br/>' .  str_replace(['<p', '</p>'], ['<span', '</span>'], $value->alamat_organisasi) : '';
                        $no_tlpn = $value->telepon != '' ? '<br/>Telp. ' . $value->telepon : '';

                        //KOTA KABUPATEN
                        if ($value->nama_kota_kabupaten != '') {

                            if ($value->kode_pos != '') {
                                $kode_pos = ' - ' . $value->kode_pos;
                            } else {
                                $kode_pos = '';
                            }

                            $nama_kota_kabupaten = '<br/>' . str_replace(['Kota', 'Kabupaten'], '', $value->nama_kota_kabupaten) . $kode_pos;
                        } else {
                            $nama_kota_kabupaten = '';
                        }

                        $arr_kop[] = '<tr>
                                        <th><b>' . $no++ . '</b></th>
                                        <td>
                                            <div class="outer-box">
                                                <div style="font-size: 11px; color: #FFFFFF;">Tanpa Border</div>
                                                <div class="box-edge">
                                                    <div class="box-no-border">
                                                        <p><span>Kepada Yth.</span><br><b>' . $value->nama_surat_ditujukan . '<br>' . $nama_organisasi . $alamat_organisasi . $nama_kota_kabupaten . $no_tlpn . '</b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>';
                    }


                    $btn_kop = '<a class="btn btn-secondary btn-icon" title="Alamat Kop Surat" data-toggle="modal" data-target="#kop_surat' . $row->id_branch_agency . '"><i class="fas fa-envelope-open-text"></i></a>
                    
                    
                    <div class="modal fade" id="kop_surat' . $row->id_branch_agency . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <span class="modal-title font-size-h6 text-primary" id="exampleModalLabel">' . $row->nama_organisasi_utama . '</span>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-hover">' . implode("", $arr_kop) . '</table>
                                </div>
                            </div>
                        </div>
                    </div>';
                    return $btn_kop;
                })
                ->addColumn('btn_action', function ($row) {

                    $btn_action  = '<div class="dropdown dropdown-inline mr-2">
                    <button type="button" class="btn btn-light-primary font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
                                    <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
                                </g>
                            </svg>
                        </span> Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                Choose an option:</li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-arrow-right"></i>
                                    </span>
                                    <span class="navi-text">Aktivitas Organisasi</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="/master-unit/form-edit/' . $row->id_branch_agency . '" title="Edit" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-arrow-right"></i>
                                    </span>
                                    <span class="navi-text">Edit</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="javascript:void(0)" title="Hapus" onclick="delete_data(' . "'" . $row->id_branch_agency . "', '" . $row->nama_organisasi_utama . "'" . ')" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="la la-arrow-right"></i>
                                    </span>
                                    <span class="navi-text">Delete</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>';

                
                    return $btn_action;
                })

                ->filter(function ($instance) use ($request) {

                    if ($request->get('id_organisasi') != '') {
                        $instance->whereIn('id_parent', $request->get('id_organisasi'));
                    }

                    if ($request->get('id_provinsi_indonesia') != '') {
                        $instance->whereIn('id_provinsi_indonesia', $request->get('id_provinsi_indonesia'));
                    }

                    if ($request->get('id_surat_ditujukan') != '') {
                        $instance->whereIn('organisasi_surat_ditujukan.id_surat_ditujukan', $request->get('id_surat_ditujukan'));
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('view_organisasi.nama_turunan_organisasi', 'LIKE', "%$search%")
                                ->orWhere('view_organisasi.nama_organisasi_utama', 'LIKE', "%$search%")
                                ->orWhere('view_organisasi.nama_parent_data_unit', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['nama_organisasi', 'nama_organisasi_parent', 'btn_action', 'btn_kop'])
                ->make(true);
        }

        return view('master_unit.index', $this->data);
    }


    public function form_add()
    {
        $this->data = [];
        $this->data['title'] = "Tambah Unit Organisasi";

        return view('master_unit.form_add', $this->data);
    }

    public function proses_add(Request $request)
    {
        $object = [
            'branch_name'               => $request['branch_name'],
            'id_suborganization_parent' => $request['id_suborganization_parent'],
            'is_suborganization'        => 1,
            'is_instansi'               => null,
            'is_organisasi'             => null,
            'is_data_unit'              => 1,
            'address'                   => $request['address'],
            'id_kota_kab_indonesia'     => $request['id_kota_kab_indonesia'],
            'kode_pos'                  => $request['kode_pos'],
            'email'                     => $request['email'],
            'phone'                     => $request['phone'],
            'website'                   => $request['website'],
            'is_active'                 => $request['is_active'],
            'information'               => $request['information'],
            'input_id'                  => Session::get('id_users')
            // 'id_surat_ditujukan'        => $request['surat_ditujukan']
        ];
        DB::table("branch_agency")->insert($object);
        $id_branch_agency = DB::getPdo()->lastInsertId();


        foreach ($request['surat_ditujukan'] as $key => $row) {
            $result[$key] = [
                'uuid'                  => Str::uuid(),
                'id_branch_agency'      => $id_branch_agency,
                'id_surat_ditujukan'    => $row
            ];
            DB::table("organisasi_surat_ditujukan")->insert($result[$key]);
        }
        
        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_branch_agency'  => $id_branch_agency,
            'aktivitas'         => 'Menambah data unit organisasi',
            'created_at'           => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================

        Alert::success('Success', 'Berhasil Menambah Data');
        return redirect('master-unit/' . Session::get('id_users'));
    }


    public function form_edit(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Edit Unit Organisasi";
        $this->data['current'] = DB::table('view_organisasi')->where('id_branch_agency', $request->segment(3))->first();

        return view('master_unit.form_edit', $this->data);
    }

    public function proses_edit(Request $request)
    {
        $object = [
            'branch_name'               => $request['branch_name'],
            'id_suborganization_parent' => $request['id_suborganization_parent'],
            'address'                   => $request['address'],
            'id_kota_kab_indonesia'     => $request['id_kota_kab_indonesia'],
            'kode_pos'                  => $request['kode_pos'],
            'email'                     => $request['email'],
            'phone'                     => $request['phone'],
            'website'                   => $request['website'],
            'is_active'                 => $request['is_active'],
            'information'               => $request['information'],
            'update_id'                 => Session::get('id_users')
        ];
        DB::table('branch_agency')->where('id_branch_agency', $request->segment(3))->update($object);

        #Tambah Log User ==========================================
        $log = [
            'input_id'           => Session::get('id_users'),
            'id_branch_agency'  => $request->segment(3),
            'aktivitas'         => 'Mengubah data unit organisasi',
            'created_at'           => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================

        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('master-unit/' . Session::get('id_users'));
    }

    public function proses_add_surat_ditujukan(Request $request)
    {
        $result = [
            'uuid'                  => Str::uuid(),
            'id_branch_agency'      => $request->segment(3),
            'id_surat_ditujukan'    => $request['id_surat_ditujukan']
        ];
        DB::table("organisasi_surat_ditujukan")->insert($result);

        Alert::success('Success', 'Berhasil Menambah Data');
        return redirect('master-unit/form-edit/' . $request->segment(3));
    }


    public function delete_surat_kepada($id)
    {
        DB::table('organisasi_surat_ditujukan')->where('id', $id)->delete();

        echo json_encode(array("status" => true));
    }

    public function delete_organisasi($id)
    {
        // DB::table('organisasi_surat_ditujukan')->where('id_branch_agency', $id)->delete();
        // DB::table('branch_agency')->where('id_branch_agency', $id)->delete();

        $object = [
            'delete_id'     => Session::get('id_users'),
            'deleted_at'    => now(),
        ];
        DB::table('branch_agency')->where('id_branch_agency', $id)->update($object);


         #Tambah Log User ==========================================
         $log = [
            'input_id'           => Session::get('id_users'),
            'id_branch_agency'  => $id,
            'aktivitas'         => 'Menghapus data unit organisasi',
            'created_at'           => now()
        ];
        DB::table("daily_report")->insert($log);
        #End Tambah Log User =======================================

        echo json_encode(array("status" => true));
    }
}
