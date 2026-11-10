<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel detail_pembayaran: rincian biaya pemeriksaan, tindakan, dan obat.
     * Relasi ke pembayaran, pemeriksaan, tindakan, dan obat.
     */
    public function up(): void
    {
        Schema::create('detail_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('pembayaran')->cascadeOnDelete();
            $table->enum('tipe', ['pemeriksaan', 'tindakan', 'obat']);
            $table->unsignedBigInteger('referensi_id')->nullable()->comment('id pemeriksaan/tindakan/obat terkait');
            $table->string('nama_item');
            $table->string('keterangan')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('harga', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembayaran');
    }
};
