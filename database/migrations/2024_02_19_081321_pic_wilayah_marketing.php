<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pic_wilayah_marketing', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('nama_wilayah')->nullable(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pic_wilayah_marketing');
    }
};
