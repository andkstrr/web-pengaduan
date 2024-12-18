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
        Schema::create('responses', function (Blueprint $table) {
            $table->id(); // -> Primary Key
            $table->foreignId('report_id')->constrained()->cascadeOnDelete(); // Melakukan relasi ke table Report
            $table->enum('response_status', ['ON_PROCESS', 'DONE', 'REJECT']); // Status Response
            $table->foreignId('staff_id')->constrained('users')->cascadeOnDelete(); // Melakukan relasi ke table User
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};
