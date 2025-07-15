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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['pendapatan', 'pengeluaran']);
            $table->enum('sumber', ['parkir', 'kompensasi', 'operasional', 'lainnya']);
            $table->text('deskripsi')->nullable();
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->decimal('total_keuangan',10,2);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_pembayaran');
            $table->foreign('id_pembayaran')->references('id')->on('pembayarans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
