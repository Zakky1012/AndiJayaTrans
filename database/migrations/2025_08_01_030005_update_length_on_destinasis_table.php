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
        Schema::table('destinasis', function (Blueprint $table) {
            $table->string('iata_code',5)->change();
            $table->string('rute_perjalanan',50)->change();
            $table->string('kota',30)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // panjang sebelumnya
        Schema::table('destinasis', function (Blueprint $table) {
            $table->string('iata_code',255)->change();
            $table->string('rute_perjalanan',255)->change();
            $table->string('kota',255)->change();
        });
    }
};
