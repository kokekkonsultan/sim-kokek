<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permintaan_karyawans', function (Blueprint $table) {
            $table->increments('idpk');
            $table->string('posisi')->nullable();
            $table->integer('jumlah')->nullable();
            $table->dateTime('tglPerlu')->nullable();
            $table->string('status')->nullable();
            $table->longText('uraianjbtn')->nullable();
            $table->longText('dasarminta')->nullable();
            $table->longText('syarat')->nullable();
            $table->longText('syaratkhusus')->nullable();
            $table->integer('idcreator')->nullable();
            $table->dateTime('creatordate')->nullable();
            $table->timestamps();
        });
    }
};
