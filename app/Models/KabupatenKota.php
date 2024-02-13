<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KabupatenKota extends Model
{
    protected $table = 'kota_kab_indonesia';

    protected $primaryKey = 'id_provinsi_indonesia';

    protected $fillable = ['id_provinsi_indonesia', 'nama_kota_kab_indonesia', 'nama_kota_kab_inisial'];

    public function provinsi()
    {
        return $this->belongsTo('App\Provinsi', 'id_provinsi_indonesia');
    }
    
}
