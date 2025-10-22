<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_skills', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('job_posting_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignUlid('skill_id')->nullable()->constrained('skills_catalog')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Información de la habilidad requerida
            $table->string('name', 150);
            $table->string('importance', 50)->nullable(); // required, nice_to_have, optional
            $table->string('proficiency', 50)->nullable(); // beginner, intermediate, advanced
            $table->unsignedSmallInteger('priority')->default(1); // para orden de relevancia
            $table->boolean('verified')->default(true);

            // Datos adicionales
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['job_posting_id', 'name']);
            $table->index(['company_id', 'importance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_skills');
    }
};
