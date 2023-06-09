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
            $table->tinyInteger('max_ticket_purchase')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lucky_draw_games', function (Blueprint $table) {
            $table->dropColumn('max_ticket_purchase');
        });
    }
};
