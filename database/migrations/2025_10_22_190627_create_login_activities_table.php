<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('login_activities', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Información del inicio/cierre de sesión
            $table->string('event', 20)->default('login'); // login, logout, failed
            $table->timestamp('occurred_at')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('device', 120)->nullable();
            $table->string('location', 120)->nullable(); // ciudad o país detectado por IP

            // Estado y control
            $table->boolean('successful')->default(true);
            $table->string('failure_reason', 255)->nullable();
            $table->json('metadata')->nullable(); // token_id, proveedor oauth, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['user_id', 'occurred_at']);
            $table->index(['company_id', 'event']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_activities');
    }
};
