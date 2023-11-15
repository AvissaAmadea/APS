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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('nip')->unique();
            $table->string('jabatan');

            $table->unsignedBigInteger('id_dinas')->nullable()->change();
 
            $table->string('nama_dinas');
            $table->string('telp');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->unique();
            $table->string('status')->default('inactive');

            $table->unsignedBigInteger('id_role')->nullable()->change();

            $table->rememberToken();
            $table->timestamps();

            $table->foreignId('id_dinas')->nullable()->constrained('dinas')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('id_role')->nullable()->constrained('roles')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
