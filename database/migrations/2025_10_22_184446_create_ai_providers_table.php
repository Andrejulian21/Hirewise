<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ai_providers', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Identificación
            $table->string('name', 120)->unique(); // Ej: OpenAI, HuggingFace, Anthropic, LocalAI
            $table->string('provider_key', 100)->nullable()->unique(); // identificador interno o alias
            $table->string('type', 80)->nullable(); // embedding, nlp, classifier, matching, etc.

            // Configuración de API
            $table->string('api_base_url', 255)->nullable();
            $table->string('default_model', 120)->nullable();
            $table->json('available_models')->nullable(); // lista de modelos soportados
            $table->boolean('is_active')->default(true);

            // Control y seguridad
            $table->string('auth_method', 50)->nullable(); // api_key, oauth2, none
            $table->string('api_key', 255)->nullable(); // cifrada con Laravel Vault
            $table->json('metadata')->nullable(); // costos, límites, configuración

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_providers');
    }
};
