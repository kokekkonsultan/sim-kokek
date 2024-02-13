<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;

use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function index()
    {
        return view('kirim_email.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);

        // dispatch(new SendMailJob($data));


        $email = new SendEmail($data);
        Mail::to($request->email)->send($email);

        return redirect()->route('kirim-email')->with('status', 'Email berhasil dikirim');
    }

}
