<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Identidad
            $table->ulid('id')->primary();

            // Relación con empresa (multi-tenant)
            $table->foreignUlid('company_id')
                ->nullable()
                ->constrained('companies')
                ->nullOnDelete();

            // Información personal y de acceso
            $table->string('name', 160);
            $table->string('email', 190)->unique();
            $table->string('password');
            $table->string('phone', 40)->nullable();
            $table->string('position', 120)->nullable(); // cargo o rol interno
            $table->string('avatar_path', 255)->nullable();

            // Roles internos
            $table->enum('role', ['admin', 'recruiter', 'viewer', 'candidate'])->default('recruiter');

            // Estado y seguridad
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
    
};
