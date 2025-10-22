<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_deletion_requests', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relaciones
            $table->foreignUlid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUlid('company_id')->nullable()->constrained('companies')->nullOnDelete();

            // Detalles de la solicitud
            $table->string('entity_type', 120)->nullable(); // tipo de entidad a eliminar (User, Candidate, Application, etc.)
            $table->ulid('entity_id')->nullable();          // ID específico si aplica
            $table->enum('status', ['pending','in_progress','completed','rejected'])->default('pending')->index();
            $table->text('reason')->nullable();
            $table->string('requested_by', 120)->nullable(); // usuario o sistema que inicia la solicitud

            // Trazabilidad y fechas
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
            $table->json('metadata')->nullable(); // info adicional: origen, logs, IP, etc.

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_deletion_requests');
    }
};
