<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('candidate_skills', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignUlid('skill_id')->nullable()->constrained('skills_catalog')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Información de la habilidad
            $table->string('name', 150); // nombre detectado o declarado
            $table->string('proficiency', 50)->nullable(); // nivel: beginner, intermediate, advanced
            $table->unsignedSmallInteger('years_experience')->nullable();
            $table->boolean('verified')->default(false); // validada por IA o manualmente

            // Origen
            $table->string('source', 100)->nullable(); // resume, linkedin, manual
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['candidate_id', 'name']);
            $table->index(['company_id', 'verified']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_skills');
    }
};
