<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DailyReport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class WeeklyPlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Weekly Planning";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));


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
                ->rawColumns(['dibuat', 'date_follow_up', 'tl'])
                ->filter(function ($instance) use ($request) {
                    if ($request->get('id_user') != '') {
                        $instance->where('input_id', $request->get('id_user'));
                    }
                    if ($request->get('tgl_mulai') != '') {
                        $instance->where('created_at', '>=', $request->get('tgl_mulai'));
                    } else {
                        $instance->where(DB::raw("YEARWEEK(created_at, 3)"), DB::raw("YEARWEEK(now(), 3)"));
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

        return view('weekly_planning.index', $this->data);

        // $arr_date = explode("-", date('Y-m-d'));
        // $date =  date('YW', mktime(0, 0, 0, $arr_date[1], $arr_date[2], $arr_date[0]));

        // $calls = DB::table('planning_report') 
        //     ->where('is_planning', 1) 
        //     ->where(DB::raw("YEARWEEK(follow_up_date, 3)"), DB::raw("YEARWEEK(now(), 3)"))
        //     ->get();
        // var_dump($calls);
    }   
}
