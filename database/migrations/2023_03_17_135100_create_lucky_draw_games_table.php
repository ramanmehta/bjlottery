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
        Schema::create('lucky_draw_games', function (Blueprint $table) {
            $table->id();
            $table->string('game_title');
            $table->text('game_description');
            $table->string('game_image');
            $table->double('winning_prize_amount');
            $table->double('minimum_prize_amount');
            $table->bigInteger('points_per_ticket');
            $table->string('start_date_time');
            $table->string('end_date_time');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lucky_draw_games');
    }
};
