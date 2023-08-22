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
        Schema::create('tikets', function (Blueprint $table) {
            $table->id('no_tiket');
            $table->string('nama');
            $table->string('instansi');
            $table->string('email');
            $table->string('no_telp');
            $table->string('judul_keluhan');
            $table->text('ket_keluhan');
            $table->text('sebab');
            $table->timestamp('tgl_pembuatan')->default(now());
            $table->date('tgl_expired');
            $table->text('catatan_kaki');
            $table->string('bukti');
            $table->unsignedBigInteger('id_prioritas');
            $table->unsignedBigInteger('id_status');
            $table->string('nama_pic');
            $table->timestamps();
            
        });
        
        Schema::table('tikets', function (Blueprint $table) {
            $table->foreign('id_prioritas')->references('id_prioritas')->on('prioritas')->onDelete('cascade');
            $table->foreign('id_status')->references('id_status')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
