<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel pembayaran: total biaya pemeriksaan, tindakan, obat, dan kuitansi.
     * Relasi ke pendaftaran.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete();
            $table->string('no_kuitansi')->unique();
            $table->date('tanggal_bayar');
            $table->decimal('total_tindakan', 12, 2)->default(0);
            $table->decimal('total_obat', 12, 2)->default(0);
            $table->decimal('total_biaya', 12, 2)->default(0);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'e-wallet', 'kartu_debit', 'kartu_kredit'])->default('tunai');
            $table->enum('status', ['belum_bayar', 'lunas', 'batal'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
