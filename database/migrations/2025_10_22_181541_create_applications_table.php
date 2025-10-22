<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones principales
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('job_posting_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignUlid('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignUlid('recruiter_id')->nullable()->constrained('users')->nullOnDelete();

            // Estado del proceso
            $table->enum('status', [
                'applied',       // recién postulado
                'in_review',     // en análisis
                'interview',     // citado
                'offered',       // oferta enviada
                'hired',         // contratado
                'rejected',      // descartado
                'withdrawn'      // retiró su postulación
            ])->default('applied')->index();

            $table->timestamp('applied_at')->nullable();
            $table->timestamp('last_status_change_at')->nullable();

            // Datos adicionales
            $table->string('source', 100)->nullable(); // portal, referido, etc.
            $table->decimal('match_score', 5, 2)->nullable(); // score IA (0–100)
            $table->json('match_breakdown')->nullable(); // explicación del score
            $table->text('notes')->nullable(); // comentarios del reclutador
            $table->json('metadata')->nullable(); // info extendida (ip, user_agent, etc.)

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices frecuentes
            $table->index(['company_id', 'status']);
            $table->index(['job_posting_id', 'candidate_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
