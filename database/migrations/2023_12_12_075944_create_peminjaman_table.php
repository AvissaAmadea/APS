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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_pinjam')->unique();

            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->onUpdate('cascade');

            $table->unsignedBigInteger('aset_id')->nullable()->change();
            $table->foreignId('aset_id')->nullable()->constrained('asets')->onDelete('set null')->onUpdate('cascade');

            $table->dateTime('tgl_pinjam');
            $table->dateTime('tgl_kembali');
            $table->string('tujuan');

            $table->string('surat_pinjam');

            $table->enum('status_pinjam', ['Diterima', 'Menunggu Verifikasi', 'Ditolak'])->default('Menunggu Verifikasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
