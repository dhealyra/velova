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
        Schema::create('data_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('no_polisi')->unique()->nullable();
            $table->enum('jenis_kendaraan', ['motor', 'mobil', 'sepeda', 'lainnya']);
            $table->string('nama_pemilik')->nullable();
            $table->enum('status_pemilik', ['dokter', 'suster', 'staff', 'tamu']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kendaraans');
    }
};
