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
                    $nama_organisasi = $row->nama_organisasi_utama;
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


                    $btn_kop = '<a class="btn btn-light-primary btn-icon" title="Alamat Kop Surat" data-toggle="modal" data-target="#kop_surat' . $row->id_branch_agency . '"><i class="fas fa-envelope-open-text"></i></a>
                    
                    
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

                    $btn_action = '<a class="btn btn-secondary font-weight-bold mr-2" href="/master-unit/form-edit/' . $row->id_branch_agency . '" title="Edit"><i class="fa fa-edit"></i> Edit</a>

                    <a class="btn btn-secondary font-weight-bold" href="javascript:void(0)" title="Hapus" onclick="delete_data(' . "'" . $row->id_branch_agency . "', '" . $row->nama_organisasi_utama . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';
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
                            $w->orWhere('view_organisasi_slim.nama_turunan_organisasi', 'LIKE', "%$search%")
                                ->orWhere('view_organisasi_slim.nama_organisasi_utama', 'LIKE', "%$search%");
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
        ];
        DB::table('branch_agency')->where('id_branch_agency', $request->segment(3))->update($object);

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
        DB::table('organisasi_surat_ditujukan')->where('id_branch_agency', $id)->delete();
        DB::table('branch_agency')->where('id_branch_agency', $id)->delete();

        echo json_encode(array("status" => true));
    }
}
