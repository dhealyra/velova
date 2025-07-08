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
        Schema::create('kompensasis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_kendaraan_keluar');
        $table->enum('tingkat_kerusakan', ['ringan', 'berat'])->default('ringan');
        $table->decimal('kompensasi_disetujui', 10, 2);
        $table->string('nama_pemilik');
        $table->text('keterangan')->nullable();
        $table->foreign('id_kendaraan_keluar')->references('id')->on('kendaraan_keluars')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kompensasis');
    }
};
