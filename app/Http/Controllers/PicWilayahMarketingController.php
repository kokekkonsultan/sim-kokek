<?php

namespace App\Http\Controllers;

use App\Models\Rup;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PicWilayahMarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Data PIC Wilayah Marketing";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));


        $data = DB::table('pic_wilayah_marketing')->groupBy('id_user');
        // var_dump($data->get());
        
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('search'))) {
                //         $instance->where(function ($w) use ($request) {
                //             $search = $request->get('search');
                //             $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                //                 ->orWhere('nama_organisasi', 'LIKE', "%$search%")
                //                 ->orWhere('id_sis_rup', 'LIKE', "%$search%");
                //         });
                //     }
                // })
                ->addColumn('pic', function ($row) {
                    $data = DB::table('users')->where('id', $row->id_user)->first();
                    $pic = $data->first_name . ' ' . $data->last_name;
                    return $pic;
                })
                ->addColumn('wilayah', function ($row) {

                    $arr = [];
                    foreach(DB::table('pic_wilayah_marketing')->where('id_user', $row->id_user)->get() as $value){
                        $arr[] = '<li>' . $value->nama_wilayah . '</li>';
                    }
                    $wilayah = implode("", $arr);
                    
                    return $wilayah;
                })
                ->addColumn('btn', function ($row) {
                    $data = DB::table('users')->where('id', $row->id_user)->first();
                    $pic = $data->first_name . ' ' . $data->last_name;


                    $btn = '<a class="btn btn-secondary btn-sm font-weight-bold" href="/pic-wilayah-marketing/form-edit/' . $row->id_user . '"><i class="fa fa-edit"></i> Edit</a>
                    
                    <a class="btn btn-secondary font-weight-bold" href="javascript:void(0)" title="Hapus" onclick="delete_data(' . "'" . $row->id_user . "', '" . $pic . "'" . ')"><i class="fa fa-trash"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['btn', 'pic', 'wilayah'])
                ->make(true);
        }


        return view('pic_wilayah_marketing.index', $this->data);
    }

    public function form_add()
    {
        $this->data = [];
        $this->data['title'] = "Tambah PIC Wilayah";


        return view('pic_wilayah_marketing.form_add', $this->data);
    }

    public function proses_add(Request $request)
    {
        $pic = $request['pic'];
        $nama_wilayah = $request['nama_wilayah'];
        foreach($nama_wilayah as $key => $row){
            $object[$key] = [
                'id_user'           => $pic,
                'nama_wilayah'      => $row,
                'created_at'        => now()
            ];
            DB::table("pic_wilayah_marketing")->insert($object[$key]);
        }

        //DELETE NAMA WILAYAH YANG KOSONG
        DB::select("DELETE FROM pic_wilayah_marketing WHERE id_user = $pic && nama_wilayah IS NULL");

        Alert::success('Success', 'Berhasil Menambah Data');
        return redirect('pic-wilayah-marketing/' . Session::get('id_users'));
    }

    public function form_edit()
    {
        $this->data = [];
        $this->data['title'] = "Edit PIC Wilayah";


        return view('pic_wilayah_marketing.form_edit', $this->data);
    }

    public function proses_edit(Request $request)
    {
        $pic = $request['pic'];
        $object = [
            'id_user'           => $pic,
            'updated_at'        => now()
        ];
        DB::table('pic_wilayah_marketing')->where('id_user', $request->segment(3))->update($object);


        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('pic-wilayah-marketing/' . Session::get('id_users'));
    }

    public function delete_data($id)
    {
        DB::table('pic_wilayah_marketing')->where('id_user', $id)->delete();

        echo json_encode(array("status" => true));
    }


    public function add_wilayah(Request $request)
    {
        $object = [
            'id_user'           => $request->segment(3),
            'nama_wilayah'      => $request['nama_wilayah'],
            'created_at'        => now()
        ];
        DB::table("pic_wilayah_marketing")->insert($object);

        Alert::success('Success', 'Berhasil Menambah Data');
        return redirect('pic-wilayah-marketing/form-edit/' . $request->segment(3));
    }

    public function edit_wilayah(Request $request)
    {
        $object = [
            'nama_wilayah'      => $request['nama_wilayah'],
            'updated_at'        => now()
        ];
        DB::table('pic_wilayah_marketing')->where('id', $request['id'])->update($object);


        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('pic-wilayah-marketing/form-edit/' . $request->segment(3));
    }

    public function delete_wilayah($id)
    {
        DB::table('pic_wilayah_marketing')->where('id', $id)->delete();

        echo json_encode(array("status" => true));
    }
}
