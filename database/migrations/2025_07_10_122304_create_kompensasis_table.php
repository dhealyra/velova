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
            $table->string('bukti')->nullable();
            $table->enum('jenis_kompensasi', ['rusak', 'kehilangan'])->default('rusak');
            $table->boolean('tipe_kompensasi')->default(0);
            $table->decimal('kompensasi_disetujui', 10, 2)->nullable();
            $table->string('nama_pemilik');
            $table->text('keterangan')->nullable();
            $table->enum('status_pengajuan', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
