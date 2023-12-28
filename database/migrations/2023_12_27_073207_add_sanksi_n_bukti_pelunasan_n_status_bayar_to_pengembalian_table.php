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
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->decimal('sanksi', 10, 2)->nullable();
            $table->string('bukti_pelunasan')->nullable();
            $table->enum('status_pelunasan', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            //
        });
    }
};
