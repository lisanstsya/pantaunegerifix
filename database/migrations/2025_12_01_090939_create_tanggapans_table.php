<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tanggapans', function (Blueprint $table) {
            $table->id();

            // Relasi ke laporan
            $table->foreignId('laporan_id')
                  ->constrained('laporans')
                  ->cascadeOnDelete();

            // Relasi ke pemerintah/user yang menanggapi
            $table->foreignId('pemerintah_id')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Nama pejabat & jabatan (agar bisa tampil di card tanpa join setiap saat)
            $table->string('petugas');
            $table->string('jabatan');

            // Isi tanggapan/solusi
            $table->text('isi');

            // Foto bukti tanggapan (opsional)
            $table->string('foto')->nullable();

            // Tanggal selesai penanganan
            $table->date('tanggal_selesai');

            // Status tanggapan (selesai/proses)
            $table->string('status')->default('selesai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanggapans');
    }
};
