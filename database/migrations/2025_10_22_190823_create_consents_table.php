<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('consents', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Tipo de consentimiento
            $table->string('type', 120); // Ej: terms_of_service, privacy_policy, cookies, marketing
            $table->string('version', 20)->nullable(); // versión del documento aceptado
            $table->boolean('granted')->default(true);

            // Contexto
            $table->timestamp('granted_at')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->json('metadata')->nullable(); // datos adicionales (idioma, país, etc.)

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique(['user_id', 'type', 'version']);
            $table->index(['company_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consents');
    }
};
