<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi_indonesia';

    protected $primaryKey = 'id_provinsi_indonesia';

    protected $fillable = ['nama_provinsi_indonesia', 'input_id'];

    public function kab_kota()
    {
        return $this->hasMany('App\KabupatenKota', 'id_kota_kab_indonesia');
    }

}
