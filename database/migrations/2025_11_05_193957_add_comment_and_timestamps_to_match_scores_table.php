<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('match_scores', function (Blueprint $table) {
            // Comentario del análisis de Gemini
            $table->text('comment')->nullable()->after('compatibility_score');

            // Timestamps requeridos por Eloquent
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::table('match_scores', function (Blueprint $table) {
            $table->dropColumn(['comment', 'created_at', 'updated_at']);
        });
    }
};
