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
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lahan');
            $table->string('nama_kelompok_tani');
            $table->string('nomor_kartu_tani')->nullable();
            $table->string('luas_lahan');
            $table->string('luas_tanam');
            $table->string('isi_lahan');
            $table->string('pemilik_lahan');
            $table->text('alamat_lahan');
            $table->text('denah_lahan');
            $table->string('gambar');
            $table->integer('hasil_panen');
            $table->date('awal_tanam');
            $table->date('akhir_tanam');
            $table->enum('status', ['berjalan', 'selesai']);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahans');
    }
};
