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
        Schema::create('kendaraan_masuks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('waktu_masuk');
            $table->unsignedBigInteger('id_kendaraan');
            $table->boolean('status_parkir')->default(0);
            $table->foreign('id_kendaraan')->references('id')->on('data_kendaraans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan_masuks');
    }
};
