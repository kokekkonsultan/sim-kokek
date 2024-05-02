<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FipMkt extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $table = 'view_fip_marketing';

}