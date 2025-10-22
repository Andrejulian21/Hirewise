<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('outbox_events', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Multi-tenant y trazabilidad
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->string('aggregate_type', 150)->nullable(); // modelo origen del evento
            $table->ulid('aggregate_id')->nullable();          // id del modelo origen

            // Identidad del evento
            $table->string('event_name', 180);                 // ej: candidate.created
            $table->string('event_version', 20)->default('1');
            $table->string('correlation_id', 64)->nullable()->index();
            $table->string('causation_id', 64)->nullable();

            // Destino y entrega
            $table->string('destination', 180)->nullable();    // cola, tópico o webhook
            $table->json('headers')->nullable();
            $table->json('payload')->nullable();

            // Control de entrega
            $table->enum('status', ['pending','dispatched','failed'])->default('pending')->index();
            $table->unsignedSmallInteger('attempts')->default(0);
            $table->timestamp('next_attempt_at')->nullable()->index();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('error_message', 255)->nullable();

            // Ordenación/partición opcional
            $table->string('partition_key', 120)->nullable();
            $table->string('ordering_key', 120)->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices útiles
            $table->index(['company_id', 'status']);
            $table->index(['aggregate_type', 'aggregate_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outbox_events');
    }
};
