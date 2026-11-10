<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pendaftaran: nomor pendaftaran, tanggal, keluhan pasien.
     * Relasi ke pasien dan jadwal_dokter.
     */
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran')->unique();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('jadwal_dokter_id')->nullable()->constrained('jadwal_dokter')->nullOnDelete();
            $table->date('tanggal_daftar');
            $table->text('keluhan');
            $table->enum('status', ['terdaftar', 'diproses', 'selesai', 'batal'])->default('terdaftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
