<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('application_stage_changes', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones principales
            $table->foreignUlid('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignUlid('from_stage_id')->nullable()->constrained('application_stages')->nullOnDelete();
            $table->foreignUlid('to_stage_id')->nullable()->constrained('application_stages')->nullOnDelete();
            $table->foreignUlid('changed_by')->nullable()->constrained('users')->nullOnDelete();

            // Información del cambio
            $table->timestamp('changed_at')->nullable()->index();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // info adicional como origen o automatización

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['application_id', 'changed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_stage_changes');
    }
};
