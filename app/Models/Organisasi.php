<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;

    public $guarded = [];
    // protected $searchableColumns = ['nama_organisasi_utama'];
    protected $table = 'view_organisasi';
}
