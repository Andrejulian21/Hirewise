<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación con el rol
            $table->foreignUlid('role_id')->constrained('roles')->cascadeOnDelete();

            // Relación polimórfica (User, Recruiter, etc.)
            $table->ulidMorphs('model'); // model_id + model_type

            // Multi-tenant
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Control y metadatos
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable(); // asignado_por, fecha, notas, etc.

            // Auditoría
            $table->timestamps();

            // Índices
            $table->unique(['role_id', 'model_id', 'model_type'], 'unique_model_role');
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_has_roles');
    }
};
