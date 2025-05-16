<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) { 
            $table->uuid('id')->primary();
            $table->foreignId('employer_id')->constrained()->onDelete('cascade');
            $table->string('title', 255);
            $table->string('country', 100)->nullable();
            $table->json('experience_level_range');
            $table->text('responsibilities');
            $table->json('skills');
            $table->json('qualifications');
            $table->json('salary_range');
            $table->json('benefits')->nullable();
            $table->json('location');
            $table->enum('work_type', ['remote', 'on_site', 'hybrid']);
            $table->timestamp('application_deadline');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs'); 
    }
};