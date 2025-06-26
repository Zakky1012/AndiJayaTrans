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
            $table->int('kode');
            $table->foreignId('keberangkatan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_keberangkatan_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('email');
            $table->string('nomor_hp');
            $table->integer('nomor_pessenger');
            $table->foreignId('kode_promo_id')->nullable()->constrained()->cascadeOnDelete();
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
