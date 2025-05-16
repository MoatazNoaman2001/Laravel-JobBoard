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
        Schema::create('conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('employer_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('candidate_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique('application_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};