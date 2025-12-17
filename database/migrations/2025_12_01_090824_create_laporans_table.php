<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('laporans');

        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('judul');
            $table->text('isi');
            $table->string('media');
            $table->date('tanggal_kejadian');
            $table->string('lokasi_detail');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('kabupaten_kota');
            $table->text('permintaan_solusi');
            $table->string('status')->default('baru');
            $table->string('kategori');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
