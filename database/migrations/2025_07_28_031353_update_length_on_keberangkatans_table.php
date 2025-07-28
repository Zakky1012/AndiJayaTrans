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
        Schema::table('keberangkatans', function (Blueprint $table) {
            $table->string('nomor_keberangkatan', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // panjang sebelumnya
        Schema::table('keberangkatans', function (Blueprint $table) {
            $table->string('nomor_keberangkatan', 255)->change();
        });
    }
};
