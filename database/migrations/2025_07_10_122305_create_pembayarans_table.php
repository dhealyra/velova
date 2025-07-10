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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kendaraan_masuk');
            $table->unsignedBigInteger('id_kendaraan_keluar');
            $table->unsignedBigInteger('id_kompensasi')->nullable();
            $table->decimal('denda', 10, 2)->nullable();
            $table->decimal('tarif', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('pembayaran', ['tunai', 'qrish', 'gratis'])->default('gratis');
            $table->foreign('id_kendaraan_masuk')->references('id')->on('kendaraan_masuks')->onDelete('cascade');
            $table->foreign('id_kendaraan_keluar')->references('id')->on('kendaraan_keluars')->onDelete('cascade');
            $table->foreign('id_kompensasi')->references('id')->on('kompensasis')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
