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
        Schema::table('users', function (Blueprint $table) {
            $table->string('name',30)->change();
            $table->string('email',50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // panjang sebelumnya
        Schema::table('users', function (Blueprint $table) {
            $table->string('name',255)->change();
            $table->string('email',255)->change();
        });
    }
};
