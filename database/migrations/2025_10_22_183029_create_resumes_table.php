<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('uploaded_by')->nullable()->constrained('users')->nullOnDelete();

            // Datos del archivo
            $table->string('original_filename', 255);
            $table->string('stored_path', 255);
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->string('hash', 128)->nullable()->index(); // checksum del archivo

            // Procesamiento de IA / NLP
            $table->text('extracted_text')->nullable(); // texto plano extraído
            $table->json('parsed_data')->nullable();   // datos estructurados: skills, educación, experiencia
            $table->boolean('is_parsed')->default(false)->index();

            // Estado y control
            $table->enum('status', ['uploaded','processed','error'])->default('uploaded')->index();
            $table->timestamp('processed_at')->nullable();
            $table->json('metadata')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['candidate_id', 'status']);
            $table->index(['company_id', 'is_parsed']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
