<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('job_posting_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignUlid('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();

            // Resultados del matching
            $table->decimal('score', 5, 2)->nullable(); // valor 0–100
            $table->json('breakdown')->nullable(); // desglose por categorías (skills, experiencia, educación)
            $table->string('model_used', 120)->nullable();
            $table->timestamp('matched_at')->nullable()->index();
            $table->boolean('is_valid')->default(true);

            // Información de control
            $table->enum('status', ['pending','processed','reviewed'])->default('processed');
            $table->foreignUlid('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('metadata')->nullable(); // batch_id, fuente, versión modelo, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices para rendimiento
            $table->unique(['job_posting_id', 'candidate_id']);
            $table->index(['company_id', 'score']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
