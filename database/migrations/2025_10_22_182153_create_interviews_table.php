<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones principales
            $table->foreignUlid('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignUlid('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignUlid('recruiter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();

            // Información general
            $table->string('title', 180)->nullable(); // Ej: “Entrevista técnica Backend”
            $table->text('description')->nullable();
            $table->enum('mode', ['onsite','remote','phone'])->default('remote'); // modo de entrevista
            $table->string('location', 255)->nullable(); // link o dirección física
            $table->timestamp('scheduled_at')->nullable()->index();
            $table->integer('duration_minutes')->nullable(); // duración estimada
            $table->string('status', 40)->default('scheduled')->index(); // scheduled, completed, cancelled

            // Resultados
            $table->text('feedback')->nullable();
            $table->unsignedTinyInteger('rating')->nullable(); // calificación 1–5
            $table->foreignUlid('next_stage_id')->nullable()->constrained('application_stages')->nullOnDelete(); // siguiente etapa recomendada

            // Extras
            $table->json('participants')->nullable(); // emails u otros asistentes
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['company_id', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
