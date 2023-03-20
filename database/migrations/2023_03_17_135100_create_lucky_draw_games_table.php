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
            $table->string('game_description');
            $table->string('game_image');
            $table->double('winning_prize_amount');
            $table->integer('min_point');
            $table->integer('max_point');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->tinyInteger('status');
            $table->integer('game_point');
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
