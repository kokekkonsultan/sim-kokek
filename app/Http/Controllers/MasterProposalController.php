<?php

namespace App\Http\Controllers;

use App\Models\MasterProposal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MasterProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Master Proposal";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));


        $masterProposal = MasterProposal::orderBy('created_at', 'desc');
        if ($request->ajax()) {
            return Datatables::of($masterProposal)
                ->addIndexColumn()
                ->addColumn('date', function ($row) {

                    $date = date('d-m-Y', strtotime($row->created_at));
                    return $date;
                })
                ->addColumn('btn', function ($row) {

                    $btn = '<a class="btn btn-light-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#edit' . $row->id . '"><i class="fa fa-edit"></i> Edit</a>
                    <button class="btn btn-light-primary btn-sm font-weight-bold" href="javascript:void(0)" onclick="delete_data(' . $row->id . ')"><i class="fa fa-trash"></i> Delete</button>';
                    return $btn;
                })
                ->rawColumns(['btn', 'date'])
                ->make(true);
        }

        return view('master_proposal.index', $this->data);
    }


    public function add(Request $request)
    {
        $object = [
            'id_jenis_proposal'         => $request['id_jenis_proposal'],
            'id_bidang_pekerjaan'       => $request['id_bidang_pekerjaan'],
            'nama_master_proposal'      => $request['nama_master_proposal'],
            'created_at'                => date('Y-m-d H:i:s')
        ];
        // var_dump($object);
        DB::table("master_proposal")->insert($object);


        echo json_encode(array("status" => true));

    }


    public function edit(Request $request)
    {
        $object = [
            'id_jenis_proposal'         => $request['id_jenis_proposal'],
            'id_bidang_pekerjaan'       => $request['id_bidang_pekerjaan'],
            'nama_master_proposal'      => $request['nama_master_proposal']
        ];
        // var_dump($object);

        DB::table('master_proposal')->where('id', $request['id'])->update($object);
        echo json_encode(array("status" => true));
    }
    

    public function delete_data($id)
    {
        DB::table('master_proposal')->where('id', $id)->delete();
        echo json_encode(array("status" => true));
    }
}
