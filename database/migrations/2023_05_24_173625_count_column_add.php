<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mission_submissions', function (Blueprint $table) {
            $table->integer('count')->default(0);
        });

        Schema::table('mission_prize_claims', function (Blueprint $table) {
            $table->integer('count')->default(0);
        });

        Schema::table('lucky_draw_winner_claims', function (Blueprint $table) {
            $table->integer('count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mission_submissions', function (Blueprint $table) {
            $table->dropColumn('count');
        });
        Schema::table('mission_prize_claims', function (Blueprint $table) {
            $table->dropColumn('count');
        });
        Schema::table('lucky_draw_winner_claims', function (Blueprint $table) {
            $table->dropColumn('count');
        });
    }
};
