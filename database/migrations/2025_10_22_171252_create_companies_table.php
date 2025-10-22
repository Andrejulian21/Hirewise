<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            // Identidad
            $table->ulid('id')->primary();
            $table->string('name', 160);
            $table->string('slug', 180)->unique(); // para subdominios o URLs
            $table->string('legal_name', 200)->nullable();
            $table->string('tax_id', 64)->nullable(); // NIT, CIF, VAT, etc.

            // Contacto
            $table->string('email', 190)->nullable()->index();
            $table->string('phone', 40)->nullable();
            $table->string('website', 190)->nullable();

            // Branding / white-label
            $table->string('logo_path', 255)->nullable();
            $table->string('brand_color', 16)->nullable(); // hex rgb

            // Localización
            $table->string('country_code', 2)->nullable()->index(); // ISO-3166-1 alpha-2
            $table->string('timezone', 64)->nullable()->default('UTC');
            $table->string('locale', 16)->nullable()->default('en');

            // Facturación básica
            $table->string('billing_email', 190)->nullable();
            $table->string('billing_name', 160)->nullable();
            $table->string('billing_address_line1', 180)->nullable();
            $table->string('billing_address_line2', 180)->nullable();
            $table->string('billing_city', 120)->nullable();
            $table->string('billing_state', 120)->nullable();
            $table->string('billing_postal_code', 32)->nullable();
            $table->string('billing_country_code', 2)->nullable();

            // Ciclo de vida
            $table->enum('status', ['active','trial','suspended','cancelled'])->default('trial')->index();
            $table->timestamp('trial_ends_at')->nullable()->index();
            $table->timestamp('onboarded_at')->nullable();

            // Flexibilidad por tenant
            $table->json('settings')->nullable(); // preferencias, políticas, plantillas
            $table->json('limits')->nullable();   // overrides por plan: vacantes, CVs, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['name']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
