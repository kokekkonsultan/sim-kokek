<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterOrganisasi extends Model
{
    // use HasFactory;
    // public $guarded = [];
    // protected $searchableColumns = ['nama_organisasi_utama'];
    // protected $table = 'view_organisasi';


    public static function kode()
    {
        $query = DB::table('view_organisasi_slim')
            ->Join('organisasi_surat_ditujukan', 'view_organisasi_slim.id_branch_agency', '=', 'organisasi_surat_ditujukan.id_branch_agency')
            ->select('view_organisasi_slim.*')
            ->orderBy('view_organisasi_slim.id_branch_agency', 'desc');

        return $query;
    }
}
