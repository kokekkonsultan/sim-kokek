<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\permintaanKaryawan;
use Illuminate\Support\Facades\Session;

class PermintaanKaryawanController extends Controller
{
    public function index(Request $request){
        $this->data = [];
        $this->data['title'] = "Page Permintaan Karyawan";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));

        //$PermintaanKaryawan = permintaanKaryawan::load();
        return view('recruitment.index', $this->data);
    }
}
