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
        Schema::create('response_progress', function (Blueprint $table) {
            $table->id(); // -> Primary Key
            $table->foreignId('response_id')->constrained('reports')->cascadeOnDelete(); // Melakukan relasi ke table Response
            $table->json('histories')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_progress');
    }
};
