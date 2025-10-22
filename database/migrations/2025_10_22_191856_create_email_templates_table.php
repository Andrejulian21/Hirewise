<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Multi-tenant
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Identificación
            $table->string('name', 150); // Ej: "Nueva Postulación", "Oferta Laboral"
            $table->string('slug', 160)->unique(); // unique system key
            $table->string('subject', 255);
            $table->string('category', 100)->nullable(); // ej: recruitment, notifications, system

            // Contenido
            $table->text('body_html')->nullable();
            $table->text('body_text')->nullable();
            $table->json('placeholders')->nullable(); // lista de variables dinámicas disponibles
            $table->string('language', 10)->default('en');

            // Configuración y control
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false); // protegida de eliminación
            $table->timestamp('last_used_at')->nullable();
            $table->json('metadata')->nullable(); // info adicional

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['company_id', 'name']);
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};
