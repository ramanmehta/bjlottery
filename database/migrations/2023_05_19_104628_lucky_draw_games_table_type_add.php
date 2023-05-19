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
        Schema::table('lucky_draw_games', function (Blueprint $table) {
            $table->decimal('winning_prize_amount',10,2)->nullable()->default(0)->change();
            $table->decimal('minimum_prize_amount',10,2)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lucky_draw_games', function (Blueprint $table) {
            // $table->dropColumn('type');
        });
    }
};
