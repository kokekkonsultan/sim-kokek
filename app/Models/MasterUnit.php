<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterUnit extends Model
{
    // use HasFactory;
    // public $guarded = [];
    // protected $searchableColumns = ['nama_organisasi_utama'];
    // protected $table = 'view_organisasi';


    public static function kode()
    {

        $query = DB::table('view_organisasi')
            ->Join('organisasi_surat_ditujukan', 'view_organisasi.id_branch_agency', '=', 'organisasi_surat_ditujukan.id_branch_agency')
            ->select('view_organisasi.*')
            ->where('is_instansi', NULL)
            ->where('type_parent', NULL)
            ->whereNotNull('id_parent')
            ->orderBy('view_organisasi.id_branch_agency', 'desc');

        return $query;
    }
}
