<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Usamos "job_postings" para no chocar con la tabla "jobs" del sistema de colas de Laravel.
        Schema::create('job_postings', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Tenant y autor
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('created_by')->nullable()->constrained('users')->nullOnDelete();

            // Contenido y metadatos
            $table->string('title', 180);
            $table->text('description');
            $table->json('requirements')->nullable();   // requisitos estructurados
            $table->json('skills')->nullable();         // skills requeridas
            $table->string('seniority', 40)->nullable(); // junior, mid, senior
            $table->string('employment_type', 40)->nullable(); // full_time, part_time, contract
            $table->string('modality', 40)->nullable();  // onsite, remote, hybrid

            // Ubicación
            $table->string('country_code', 2)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 120)->nullable();

            // Compensación
            $table->decimal('salary_min', 12, 2)->nullable();
            $table->decimal('salary_max', 12, 2)->nullable();
            $table->string('currency', 10)->nullable();

            // Estado del proceso
            $table->enum('status', ['draft','published','paused','closed'])->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('closed_at')->nullable();

            // Extras
            $table->string('source', 80)->nullable(); // canal de origen interno/externo
            $table->json('settings')->nullable();     // campos custom por tenant

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices frecuentes
            $table->index(['company_id', 'status']);
            $table->index(['country_code', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
