<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignUlid('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Control
            $table->boolean('is_granted')->default(true); // para permitir excepciones si se desea revocar sin eliminar registro
            $table->json('metadata')->nullable(); // información adicional (quién asignó, fecha, etc.)

            // Auditoría
            $table->timestamps();

            // Índices
            $table->unique(['role_id', 'permission_id']);
            $table->index(['company_id', 'is_granted']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_has_permissions');
    }
};
