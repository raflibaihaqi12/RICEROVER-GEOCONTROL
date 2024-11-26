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
        Schema::create('list_pupuk', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pupuk');
            $table->string('jumlah_alokasi');
            $table->integer('harga_pupuk');
            $table->string('total_nilai_subsidi');
            $table->unsignedBigInteger('alokasi_id');
            $table->timestamps();

            $table->foreign('alokasi_id')->references('id')->on('alokasi_pupuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_pupuk');
    }
};
