<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Daily Report";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));


        // #jika direksi
        // if(in_array(Session::get('id_users'), [14, 15])){
        //     $log_aktivitas = DB::table('log_aktivitas_user')->orderBy('id', 'desc');
        // } else {
        //     $log_aktivitas = DB::table('log_aktivitas_user')->where('id_user', Session::get('id_users'))->orderBy('id', 'desc');
        // }


        $log_aktivitas = DailyReport::query()->orderBy('created_at', 'desc');
        if ($request->ajax()) {
            return Datatables::of($log_aktivitas)
                ->addIndexColumn()
                ->addColumn('dibuat', function ($row) {
                    $data = date('d M Y', strtotime($row->created_at));
                    return $data;
                })
                ->addColumn('date_follow_up', function ($row) {
                    $data = $row->is_follow_up == 1 ?  date('d M Y', strtotime($row->follow_up_date)) : '';
                    return $data;
                })
                ->addColumn('tl', function ($row) {

                        if($row->is_follow_up == 1){
                            $data = $row->tindak_lanjut;
                        } else {
                            $data = '<span style="color:#B5B5C3;">Belum ada tindak lanjut</span><br/>
                            <a class="badge badge-info font-weight-bold" data-toggle="modal" onclick="showTindakLanjut(' . $row->id . ')" href="#modal_tindak_lanjut">Lakukan Tindak Lanjut</a>';
                        }
                    return $data;
                })
                ->addColumn('btn', function ($row) {

                    if(DB::table('daily_report')->where('id_sub', $row->id)->count() > 0){
                        $delete = 'onclick="alert_delete()"';
                        
                    } else {
                        $delete = 'onclick="delete_data(' . $row->id . ')"';
                    }

                    $btn = '<div class="dropdown dropdown-inline mr-2">
                        <button type="button" class="btn btn-secondary btn-sm font-weight-bold dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"></path>
                                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"></path>
                                    </g>
                                </svg>
                            </span> Action
                        </button>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <ul class="navi flex-column navi-hover py-2">
                                <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">
                                    Choose an option:</li>
                                <li class="navi-item">
                                    <a data-toggle="modal" onclick="showEdit(' . $row->id . ')" href="#modal_edit" class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-arrow-right"></i>
                                        </span>
                                        <span class="navi-text">Edit</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="javascript:void(0)" ' . $delete . ' class="navi-link">
                                        <span class="navi-icon">
                                            <i class="la la-arrow-right"></i>
                                        </span>
                                        <span class="navi-text">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>';

                    $data = $row->is_manual == 1 ? $btn : '';
                    return $data;
                })
                ->rawColumns(['dibuat', 'date_follow_up', 'tl', 'btn'])
                ->filter(function ($instance) use ($request) {
                    if ($request->get('id_user') != '') {
                        $instance->where('input_id', $request->get('id_user'));
                    }
                    if ($request->get('tgl_mulai') != '') {
                        $instance->where('created_at', '>=', $request->get('tgl_mulai'));
                    }
                    if ($request->get('tgl_sampai') != '') {
                        $instance->where('created_at', '<=', $request->get('tgl_sampai'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('aktivitas', 'LIKE', "%$search%");
                        });
                    }
                })
                ->make(true);
        }
        return view('daily_report.index', $this->data);
    }


    public function add(Request $request)
    {
        $id_contact_person = $request['id_contact_person'];
        $contact_person = DB::table('contact_person')->where('id_contact_person', $id_contact_person)->first();

        $object = [
            'aktivitas'             => $request['aktivitas'],
            'id_contact_person'     => $id_contact_person,
            'id_branch_agency'      => $contact_person->id_branch_agency,
            'input_id'              => Session::get('id_users'),
            'is_manual'             => 1,
            'created_at'            => now()
        ];
        DB::table("daily_report")->insert($object);

        return response()->json();
    }

    public function show_modal_tindak_lanjut($id)
    {
        $this->data = [];
        $this->data['current'] = DailyReport::query()->where('id', $id)->first();

        return view('daily_report.modal_tindak_lanjut', $this->data);
    }


    public function add_tindak_lanjut(Request $request)
    {
        $id = $request['id'];
        $pr = DailyReport::query()->where('id', $id)->first();

        $result = [
            'is_follow_up'          => 1,
            'tindak_lanjut'         => $request['tindak_lanjut'],
            'follow_up_date'        => $request['follow_up_date'],
            'updated_at'            => now()
        ];
        DB::table("daily_report")->where('id', $id)->update($result);


        $object = [
            'id_sub'                => $id,
            'aktivitas'             => $request['tindak_lanjut'],
            'id_contact_person'     => $pr->id_contact_person,
            'id_branch_agency'      => $pr->id_branch_agency,
            'input_id'              => Session::get('id_users'),
            'is_manual'             => 1,
            'created_at'            => $request['follow_up_date']
        ];
        DB::table("daily_report")->insert($object);

        return response()->json();
    }


    public function show_modal_edit($id)
    {
        $this->data = [];
        $this->data['current'] = DailyReport::query()->where('id', $id)->first();

        return view('daily_report.modal_edit', $this->data);
    }

    public function edit(Request $request)
    {
        $id = $request->segment(3);
        $pr = DailyReport::query()->where('id', $id)->first();

        $result = [
            'aktivitas'             => $request['aktivitas'],
            'updated_at'            => now()
        ];
        if($pr->id_sub != ''){
            $result['created_at'] = $request['created_at'];
        }
        DB::table("daily_report")->where('id', $id)->update($result);


        if($pr->id_sub != ''){
            $result = [
                'tindak_lanjut'             => $request['aktivitas'],
                'follow_up_date'            => $request['created_at'],
                'updated_at'                => now()
            ];
            DB::table("daily_report")->where('id', $pr->id_sub)->update($result);
        }

        return response()->json();
    }
   

    public function delete($id)
    {
        DB::table('daily_report')->where('id', $id)->delete();
        echo json_encode(array("status" => true));
    }
}
