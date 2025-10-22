<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skills_catalog', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Información general
            $table->string('name', 150)->unique(); // Ej: Python, Project Management, SQL
            $table->string('category', 100)->nullable(); // Ej: Programming, Soft Skill, Management
            $table->string('type', 80)->nullable(); // hard, soft, technical, language
            $table->string('slug', 160)->unique();
            $table->string('level_scale', 50)->nullable(); // beginner, intermediate, expert, etc.

            // Datos semánticos y NLP
            $table->json('synonyms')->nullable(); // para embeddings o equivalencias (AI)
            $table->json('embedding_vector')->nullable(); // representación numérica
            $table->boolean('is_active')->default(true);

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['category', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills_catalog');
    }
};
