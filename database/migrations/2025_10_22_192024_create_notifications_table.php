<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Multi-tenant y usuario destino
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Tipo y contenido
            $table->string('type', 150); // Ej: candidate.applied, interview.scheduled
            $table->string('channel', 50)->default('system'); // system, email, webhook, sms
            $table->string('title', 255);
            $table->text('message')->nullable();
            $table->json('data')->nullable(); // payload adicional con contexto
            $table->string('link', 255)->nullable(); // URL para redirigir al usuario

            // Estado de entrega
            $table->boolean('is_read')->default(false);
            $table->boolean('is_delivered')->default(false);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();

            // Control y prioridad
            $table->enum('priority', ['low','normal','high'])->default('normal');
            $table->timestamp('expires_at')->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'user_id']);
            $table->index(['is_read', 'is_delivered']);
            $table->index(['expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
