<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Información general del plan
            $table->string('name', 100)->unique(); // Free, Pro, Corporate
            $table->string('code', 80)->unique();  // free, pro, corp
            $table->text('description')->nullable();

            // Configuración de límites
            $table->json('features')->nullable();  // descripción de funciones habilitadas
            $table->json('limits')->nullable();    // límites numéricos: vacantes, CVs, usuarios, etc.

            // Precio y moneda
            $table->decimal('price_usd', 10, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->enum('billing_cycle', ['monthly','yearly'])->default('monthly');

            // Estado y orden
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('display_order')->default(0);

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['is_active', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
