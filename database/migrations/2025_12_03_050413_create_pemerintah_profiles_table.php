<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemerintah_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi ke tabel users
            $table->string('foto')->nullable();     // foto pejabat
            $table->string('nama');                 // nama pejabat
            $table->string('jabatan');              // jabatan
            $table->string('instansi');             // instansi
            $table->string('provinsi');
            $table->string('kota');
            $table->string('no_hp');                // no HP
            $table->timestamps();

            // foreign key
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemerintah_profiles');
    }
};
