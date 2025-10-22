<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('match_explanations', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // Relación principal
            $table->foreignUlid('match_id')->constrained('matches')->cascadeOnDelete();

            // Señales y desglose explicativo
            $table->json('factors')->nullable();        // pesos y contribuciones por dimensión: skills, experiencia, educación
            $table->json('top_matches')->nullable();    // coincidencias clave detectadas
            $table->json('gaps')->nullable();           // brechas relevantes
            $table->text('rationale')->nullable();      // texto breve explicando el score
            $table->json('metadata')->nullable();       // información adicional

            // Modelo y versión usados para generar la explicación
            $table->string('model_used', 120)->nullable();
            $table->string('version', 40)->nullable();

            // Auditoría
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->unique('match_id'); // 1:1 con matches
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_explanations');
    }
};
