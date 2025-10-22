<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación polimórfica
            $table->ulidMorphs('attachable'); // attachable_id + attachable_type

            // Relación con empresa y usuario
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('uploaded_by')->nullable()->constrained('users')->nullOnDelete();

            // Información del archivo
            $table->string('filename', 255);
            $table->string('path', 255);
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->string('category', 80)->nullable(); // ej: cv, portfolio, feedback, document
            $table->text('description')->nullable();

            // Metadatos adicionales
            $table->json('metadata')->nullable(); // campos personalizados, versión, checksum

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
