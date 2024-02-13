<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KabupatenKota;
use App\Provinsi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class KabupatenKotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $pagination = 25;
        $data = KabupatenKota::paginate($pagination);

        // dd($data);

        $this->data = [];
        $this->data['title'] = "Kabupaten Kota";

        if (strlen($keyword)) {
            $this->data['data'] = KabupatenKota::where('kota_kab_indonesia.nama_kota_kab_indonesia', 'like', "%$keyword%")
                // ->orWhere('provinsi_indonesia.nama_provinsi_indonesia', 'like', "%$keyword%")
                ->paginate($pagination);
        } else {
            $this->data['data'] = $data;
        }




        return view('kabupaten_kota.index', $this->data)->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data = [];
        $this->data['title'] = "Tambah Kabupaten Kota";
        $this->data['provinsi'] = Provinsi::all();

        return view('kabupaten_kota.form_add', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_kota_kab_indonesia' => 'required',
                'provinsi' => 'required',
            ]
        );
        $data = [
            'nama_kota_kab_indonesia' => $request->nama_kota_kab_indonesia,
            'id_provinsi_indonesia' => $request->provinsi,
        ];

        KabupatenKota::create($data);

        return redirect()->to('kabupaten-kota')->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data = [];
        $this->data['title'] = "Tambah Kabupaten Kota";
        $this->data['data'] = KabupatenKota::where('id_kota_kab_indonesia', $id)->first();
        $this->data['provinsi'] = Provinsi::all();

        return view('kabupaten_kota.form_edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'nama_kota_kab_indonesia' => 'required',
                'provinsi' => 'required',
            ]
        );
        $data = [
            'nama_kota_kab_indonesia' => $request->nama_kota_kab_indonesia,
            'id_provinsi_indonesia' => $request->provinsi,
        ];

        KabupatenKota::where('id_kota_kab_indonesia', $id)->update($data);

        return redirect()->to('kabupaten-kota')->with('success', 'Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KabupatenKota::where('id_kota_kab_indonesia', $id)->delete();
        return back()->with('success', 'Berhasil melakukan delete data');
    }
}
