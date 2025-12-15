<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke laporan
            $table->foreignId('laporan_id')
                  ->constrained('laporans')
                  ->cascadeOnDelete();

            // Relasi ke user pemerintah
            $table->foreignId('pemerintah_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('petugas');       // nama pejabat
            $table->string('jabatan');       // jabatan pejabat
            $table->text('komentar');        // isi tanggapan/solusi
            $table->date('tanggal_selesai')->nullable(); // optional
            $table->string('foto')->nullable();          // optional bukti foto
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
