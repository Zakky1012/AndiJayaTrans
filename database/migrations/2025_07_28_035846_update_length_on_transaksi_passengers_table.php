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
        Schema::table('transaksi_passengers', function (Blueprint $table) {
            $table->string('nama',30)->change();
            $table->string('kewarganegaraan',30)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // panjang sebelumnya
        Schema::table('transaksi_passengers', function (Blueprint $table) {
            $table->string('nama',255)->change();
            $table->string('kewarganegaraan',255)->change();
        });
    }
};
