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
        Schema::create('teknisis', function (Blueprint $table) {
            $table->id('id_teknisi');
            $table->string('fotoprofil');
            $table->string('nama_lengkap');
            $table->string('username');
            $table->string('email');
            $table->string('no_telp');
            $table->string('password');
            $table->unsignedBigInteger('role');
            $table->string('pic_admin');
            $table->unsignedBigInteger('id_status');
            $table->timestamps();
        });

        Schema::table('teknisis', function (Blueprint $table) {
            $table->foreign('role')->references('id_role')->on('roles')->onDelete('cascade');
            $table->foreign('id_status')->references('id_status')->on('status_kerjas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teknisis');
    }
};
