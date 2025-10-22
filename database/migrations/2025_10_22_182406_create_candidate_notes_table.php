<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('candidate_notes', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignUlid('author_id')->nullable()->constrained('users')->nullOnDelete();

            // Contenido
            $table->text('content'); // nota principal
            $table->string('visibility', 40)->default('private'); // private, shared, system
            $table->enum('type', ['general','feedback','alert','system'])->default('general');
            $table->json('metadata')->nullable(); // adjuntos, tags, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['candidate_id', 'type']);
            $table->index(['company_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_notes');
    }
};
