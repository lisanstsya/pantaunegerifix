<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rt_rw_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('foto')->nullable();
            $table->string('nama');
            $table->string('jabatan');
            $table->integer('rt');
            $table->integer('rw');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('no_hp');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rt_rw_profiles');
    }
};
