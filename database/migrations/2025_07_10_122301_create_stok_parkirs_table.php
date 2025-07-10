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
        Schema::create('stok_parkirs', function (Blueprint $table) {
            $table->id();
            $table->enum('status_pemilik', ['tamu', 'staff'])->default('tamu');
            $table->enum('jenis_kendaraan', ['mobil', 'motor', 'sepeda']);
            $table->integer('kapasitas');
            $table->integer('sisa_slot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_parkirs');
    }
};
