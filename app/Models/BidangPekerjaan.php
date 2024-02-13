<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class BidangPekerjaan extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $table = 'bidang_pekerjaan';

    protected $primaryKey = 'id_bidang_pekerjaan';
}
