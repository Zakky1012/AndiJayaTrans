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
        // panjang setelahnya
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('kode', 50)->change();
            $table->string('nama', 25)->change();
            $table->string('email', 50)->change();
            $table->string('nomor', 15)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // panjang sebelumnya
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('kode', 255)->change();
            $table->string('nama', 255)->change();
            $table->string('email', 255)->change();
            $table->string('nomor', 255)->change();
        });
    }
};
