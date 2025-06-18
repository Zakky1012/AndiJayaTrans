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
        Schema::create('keberangkatan_class_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kelas_keberangkatan')->references('id')->onDelete('cascade');
            $table->foreignId('id_fasilitas
            ')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keberangkatan_class_fasilitas');
    }
};
