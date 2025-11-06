<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // applications.job_id -> jobs.id (cascade)
        Schema::table('applications', function (Blueprint $table) {
            // El nombre puede variar; si falla, revisa en tu DB el nombre exacto de la FK
            $table->dropForeign(['job_id']);
            $table->foreign('job_id')
                  ->references('id')->on('jobs')
                  ->onDelete('cascade');
        });

        // match_scores.job_id -> jobs.id (cascade)
        if (Schema::hasTable('match_scores')) {
            Schema::table('match_scores', function (Blueprint $table) {
                $table->dropForeign(['job_id']);
                $table->foreign('job_id')
                      ->references('id')->on('jobs')
                      ->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->foreign('job_id')
                  ->references('id')->on('jobs'); // sin cascade
        });

        if (Schema::hasTable('match_scores')) {
            Schema::table('match_scores', function (Blueprint $table) {
                $table->dropForeign(['job_id']);
                $table->foreign('job_id')
                      ->references('id')->on('jobs'); // sin cascade
            });
        }
    }
};
