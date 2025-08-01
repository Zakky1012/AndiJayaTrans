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
        Schema::table('kursi_keberangkatans', function (Blueprint $table) {
            $table->string('name',50)->change();
            $table->string('row',5)->change();
            $table->string('column',5)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // panjang sebelumnya
        Schema::table('kursi_keberangkatans', function (Blueprint $table) {
            $table->string('name',255)->change();
            $table->string('row',255)->change();
            $table->string('column',255)->change();
        });
    }
};
