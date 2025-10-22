<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación con el permiso
            $table->foreignUlid('permission_id')->constrained('permissions')->cascadeOnDelete();

            // Relación polimórfica (User, Recruiter, etc.)
            $table->ulidMorphs('model'); // model_id + model_type

            // Multi-tenant
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Control y metadatos
            $table->boolean('is_granted')->default(true);
            $table->json('metadata')->nullable(); // info adicional: asignado_por, fecha, etc.

            // Auditoría
            $table->timestamps();

            // Índices
            $table->unique(['permission_id', 'model_id', 'model_type'], 'unique_model_permission');
            $table->index(['company_id', 'is_granted']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_has_permissions');
    }
};
