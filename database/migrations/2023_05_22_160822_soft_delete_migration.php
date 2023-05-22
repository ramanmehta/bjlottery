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
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('lucky_draw_games', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reward_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('mission_submissions', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
