<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación con la empresa
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();

            // Información del canal o fuente
            $table->string('name', 160); // Ej: LinkedIn, Computrabajo, Referido Interno
            $table->string('type', 80)->nullable(); // portal, referral, campaign, agency
            $table->string('url', 255)->nullable();
            $table->string('tracking_code', 120)->nullable(); // para seguimiento UTM o campañas
            $table->boolean('is_active')->default(true);

            // Descripción y configuración adicional
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // configuraciones específicas del canal

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices frecuentes
            $table->unique(['company_id', 'name']);
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sources');
    }
};
