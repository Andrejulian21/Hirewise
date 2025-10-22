<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_notes', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('job_posting_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('author_id')->nullable()->constrained('users')->nullOnDelete();

            // Contenido de la nota
            $table->text('content'); // texto principal
            $table->string('visibility', 40)->default('private'); // private, shared, system
            $table->enum('type', ['general','feedback','alert','system'])->default('general');
            $table->json('metadata')->nullable(); // adjuntos, tags, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices frecuentes
            $table->index(['job_posting_id', 'type']);
            $table->index(['company_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_notes');
    }
};
