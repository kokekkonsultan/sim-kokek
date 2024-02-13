<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelectFilterController extends Controller
{
    
    public function ajax_agency_category(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = DB::table('agency_category')->where('agency_category_name', 'LIKE', "%$term%")->limit(5)->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id_agency_category, 'text' => $tag->agency_category_name];
        }
        return response()->json($formatted_tags);
    }


    public function ajax_agency(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = DB::table('view_organisasi_slim')
            ->where('is_instansi', 1)
            ->where('nama_organisasi_utama', 'LIKE', "%$term%")
            ->orWhere('nama_turunan_organisasi', 'LIKE', "%$term%")
            ->limit(5)->get();

        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id_branch_agency, 'text' => $tag->nama_organisasi_utama];
        }

        return response()->json($formatted_tags);
    }



    public function ajax_organisasi(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = DB::table('view_organisasi_slim')
            ->where('is_organisasi', 1)
            ->where('nama_organisasi_utama', 'LIKE', "%$term%")
            ->orWhere('nama_turunan_organisasi', 'LIKE', "%$term%")
            ->limit(5)->get();

        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id_branch_agency, 'text' => $tag->nama_organisasi_utama];
        }

        return response()->json($formatted_tags);
    }

    public function ajax_surat_ditujukan(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = DB::table('surat_ditujukan')
            ->where('nama_susunan_organisasi', 'LIKE', "%$term%")
            ->orWhere('nama_surat_ditujukan', 'LIKE', "%$term%")
            ->limit(5)->get();

        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_susunan_organisasi . ' - ' . $tag->nama_surat_ditujukan];
        }

        return response()->json($formatted_tags);
    }
}