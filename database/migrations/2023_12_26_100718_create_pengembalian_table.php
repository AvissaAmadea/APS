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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_pinjam')->unique()->nullable();
            $table->foreign('kode_pinjam')->references('kode_pinjam')->on('peminjaman')->onDelete('set null')->onUpdate('cascade');

            $table->enum('rusak', ['Ya', 'Tidak'])->default('Tidak');
            $table->enum('hilang', ['Ya', 'Tidak'])->default('Tidak');

            $table->string('ket_rusak')->nullable();
            $table->string('ket_hilang')->nullable();

            $table->string('bukti')->nullable();

            $table->enum('status_kembali', ['Menunggu Verifikasi', 'Menunggu Pembayaran', 'Diterima', 'Ditolak']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
