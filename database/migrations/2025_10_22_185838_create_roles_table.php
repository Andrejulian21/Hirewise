<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación multi-tenant
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Información del rol
            $table->string('name', 100); // Ej: Admin, Recruiter, Viewer
            $table->string('slug', 120)->unique();
            $table->string('description', 255)->nullable();
            $table->boolean('is_default')->default(false); // rol base del sistema
            $table->boolean('is_system')->default(false);  // protegido del borrado

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['company_id', 'name']);
            $table->index(['company_id', 'is_default']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
