<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación multi-tenant (null = permiso global del sistema)
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Información del permiso
            $table->string('name', 120); // Ej: view_candidates, edit_jobs, delete_users
            $table->string('slug', 150)->unique();
            $table->string('group', 100)->nullable(); // Ej: candidates, jobs, settings
            $table->string('description', 255)->nullable();

            // Control
            $table->boolean('is_system')->default(false);  // protegido del borrado
            $table->boolean('is_active')->default(true);

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['company_id', 'name']);
            $table->index(['group', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
