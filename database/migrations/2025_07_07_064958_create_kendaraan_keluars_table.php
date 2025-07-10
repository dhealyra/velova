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
        Schema::create('kendaraan_keluars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kendaraan_masuk');
            $table->timestamp('waktu_keluar');
            $table->enum('status_kondisi', ['baik', 'rusak', 'kehilangan'])->default('baik');
            $table->enum('sebab_denda', ['tiket hilang', 'merusak', 'lainnya'])->nullable();
            $table->foreign('id_kendaraan_masuk')->references('id')->on('kendaraan_masuks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan_keluars');
    }
};
