<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('application_stages', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Tenant y referencia
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete();

            // Nombre y orden del estado
            $table->string('name', 120);              // Ej: Screening, Entrevista Técnica, Oferta, Contratado
            $table->unsignedInteger('order')->default(0)->index(); // orden en el pipeline

            // Atributos opcionales
            $table->string('color', 16)->nullable();   // color identificador para UI
            $table->boolean('is_final')->default(false); // si marca cierre del proceso
            $table->boolean('is_default')->default(false); // si es parte del pipeline base

            // Descripción y configuración extra
            $table->text('description')->nullable();
            $table->json('settings')->nullable(); // ex: recordatorios automáticos, acciones

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['company_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_stages');
    }
};
