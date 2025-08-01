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
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('nomor_plat',10)->change();
            $table->string('nama_mobil',25)->change();
            $table->string('jenis_mobil',20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // panjang sebelumnya
        Schema::table('mobils', function (Blueprint $table) {
            $table->string('nomor_plat',255)->change();
            $table->string('nama_mobil',255)->change();
            $table->string('jenis_mobil',255)->change();
        });
    }
};
