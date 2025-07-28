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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            // Disarankan menggunakan string untuk 'kode' jika bisa berisi huruf atau leading zeros
            // dan tambahkan unique() jika kode transaksi harus unik.
            $table->string('kode')->unique();

            // Perbaikan untuk foreign key: Gunakan references() dan on() secara eksplisit
            $table->foreignId('keberangkatan_id')->references('id')->on('keberangkatans')->cascadeOnDelete();

            // Perbaikan untuk foreign key: Gunakan references() dan on() secara eksplisit
            $table->foreignId('keberangkatan_class_id')->references('id')->on('class_keberangkatans')->cascadeOnDelete();

            $table->string('nama');
            $table->string('email');
            $table->string('nomor');
            $table->integer('nomor_pessenger');

            // Perbaikan untuk foreign key: Gunakan references() dan on() secara eksplisit
            $table->foreignId('kode_promo_id')->nullable()->references('id')->on('promo_codes')->cascadeOnDelete();

            $table->enum('status_payment', ['pending', 'dibayar', 'gagal'])->default('pending');
            $table->integer('sub_total')->nullable();
            $table->integer('grand_total')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
