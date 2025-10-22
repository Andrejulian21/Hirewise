<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Tenant y posible usuario vinculado
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Datos personales básicos
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 190)->nullable()->index();
            $table->string('phone', 40)->nullable();

            // Perfil profesional
            $table->string('headline', 180)->nullable();   // Ej: "Data Analyst with 5 years of experience"
            $table->text('summary')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->string('seniority', 40)->nullable();
            $table->string('education_level', 120)->nullable();

            // Experiencia
            $table->integer('years_experience')->nullable();
            $table->string('current_position', 160)->nullable();
            $table->string('current_company', 160)->nullable();

            // Ubicación
            $table->string('country_code', 2)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 120)->nullable();

            // Documentos y enlaces
            $table->string('resume_path', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('portfolio_url', 255)->nullable();

            // Estado del perfil
            $table->enum('status', ['active','inactive','hired','blacklisted'])->default('active')->index();

            // Extras y trazabilidad
            $table->json('metadata')->nullable(); // info opcional de origen, tags, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
