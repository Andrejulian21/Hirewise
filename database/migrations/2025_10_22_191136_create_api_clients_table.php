<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('api_clients', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación multi-tenant
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Información del cliente
            $table->string('name', 150);
            $table->string('client_id', 100)->unique();
            $table->string('client_secret', 255);
            $table->string('description', 255)->nullable();

            // Configuración y permisos
            $table->json('scopes')->nullable(); // ej: ["read:candidates", "write:jobs"]
            $table->string('callback_url', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_used_at')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_clients');
    }
};
