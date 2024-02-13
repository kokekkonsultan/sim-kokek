<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $this->data = [];
        $this->data['title'] = "Dashboard";

        return view('dashboard.index', $this->data);
    }
}
