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
        Schema::create('asets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_aset');
            $table->unsignedBigInteger('kategori_id')->nullable()->change();
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null')->onUpdate('cascade');
            $table->unsignedBigInteger('dinas_id')->nullable()->change();
            $table->foreignId('dinas_id')->nullable()->constrained('dinas')->onDelete('set null')->onUpdate('cascade');
            $table->string('detail');
            $table->enum('status_aset', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asets');
    }
};
