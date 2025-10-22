<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('web_settings', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación con la empresa (único por tenant)
            $table->foreignUlid('company_id')->constrained('companies')->cascadeOnDelete()->unique();

            // Configuración visual y de marca
            $table->string('theme', 50)->default('light');
            $table->string('primary_color', 20)->nullable();
            $table->string('secondary_color', 20)->nullable();
            $table->string('logo_path', 255)->nullable();
            $table->string('favicon_path', 255)->nullable();

            // Preferencias generales
            $table->string('language', 10)->default('en');
            $table->string('timezone', 50)->nullable();
            $table->boolean('maintenance_mode')->default(false);
            $table->json('navigation_links')->nullable(); // enlaces personalizados del dashboard
            $table->json('custom_scripts')->nullable();  // scripts o widgets externos

            // Privacidad y cumplimiento
            $table->boolean('require_cookie_consent')->default(true);
            $table->string('privacy_policy_url', 255)->nullable();
            $table->string('terms_url', 255)->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'language']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
