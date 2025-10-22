<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ai_jobs', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Contexto general
            $table->string('task_type', 100); // embedding, parsing, matching, explanation, etc.
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Origen del trabajo
            $table->ulid('related_id')->nullable(); // id de entidad relacionada (resume, job_posting, etc.)
            $table->string('related_type', 120)->nullable(); // clase del modelo (polimórfico manual)
            $table->foreignUlid('provider_id')->nullable()->constrained('ai_providers')->nullOnDelete();

            // Estado y control
            $table->enum('status', ['queued','processing','completed','failed'])->default('queued')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('attempts')->default(0);
            $table->string('error_message', 255)->nullable();

            // Datos de entrada y salida
            $table->json('input')->nullable();
            $table->json('output')->nullable();
            $table->json('metadata')->nullable(); // batch_id, version, modelo, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'task_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_jobs');
    }
};
