<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Información general
            $table->string('code', 50)->unique(); // Ej: HIREWISE2025
            $table->string('name', 120)->nullable(); // nombre descriptivo
            $table->text('description')->nullable();

            // Descuento
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->string('currency', 10)->nullable(); // solo aplica si es "fixed"

            // Condiciones de uso
            $table->integer('max_uses')->nullable(); // límite global
            $table->integer('uses_per_company')->nullable(); // límite por tenant
            $table->unsignedInteger('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            // Restricciones y asociación
            $table->foreignUlid('plan_id')->nullable()->constrained('plans')->nullOnDelete(); // solo para un plan específico
            $table->json('metadata')->nullable(); // condiciones personalizadas o tracking

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['is_active', 'starts_at', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
