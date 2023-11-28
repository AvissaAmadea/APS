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

            $table->unsignedBigInteger('dinas_id')->nullable()->change();
 
            $table->string('telp');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->unique();
            // $table->string('status')->default('inactive');

            $table->unsignedBigInteger('role_id')->nullable()->change();  //0:superadmin ; 1:sekda ; 2:opd

            // $table->unsignedBigInteger('role')->default(2);  //0:superadmin ; 1:sekda ; 2:opd

            $table->rememberToken();
            $table->timestamps();

            $table->foreignId('dinas_id')->nullable()->constrained('dinas')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null')->onUpdate('cascade');
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
