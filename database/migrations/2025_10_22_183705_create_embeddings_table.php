<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('embeddings', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación polimórfica
            $table->ulidMorphs('embeddable'); // embeddable_id + embeddable_type (resume, job_posting, parsed_document, etc.)

            // Información general
            $table->string('model', 120)->nullable(); // modelo usado, ej: text-embedding-3-large
            $table->unsignedSmallInteger('dimensions')->nullable();
            $table->decimal('version', 5, 2)->nullable();

            // Datos del embedding
            $table->json('vector')->nullable(); // vector numérico serializado
            $table->text('hash')->nullable(); // hash para evitar duplicados
            $table->boolean('is_active')->default(true);

            // Contexto y trazabilidad
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->timestamp('generated_at')->nullable();
            $table->json('metadata')->nullable(); // información adicional (batch_id, origen, etc.)

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('embeddings');
    }
};
