<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parsed_documents', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('resume_id')->nullable()->constrained('resumes')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('candidate_id')->nullable()->constrained('candidates')->nullOnDelete();

            // Información del documento
            $table->string('source_type', 80)->nullable(); // resume, linkedin, upload_manual, etc.
            $table->string('language', 10)->nullable(); // idioma detectado
            $table->boolean('is_valid')->default(true);

            // Texto y datos extraídos
            $table->longText('raw_text')->nullable(); // texto completo
            $table->json('entities')->nullable(); // entidades reconocidas: skills, roles, fechas
            $table->json('structure')->nullable(); // estructura jerárquica: secciones, subsecciones

            // Procesamiento y control
            $table->enum('status', ['pending','processed','error'])->default('processed')->index();
            $table->timestamp('processed_at')->nullable();
            $table->text('error_message')->nullable();

            // Metadatos adicionales
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'status']);
            $table->index(['candidate_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parsed_documents');
    }
};
