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
        Schema::create('daily_reward_points', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('daily_reward_point')->nullable();
            $table->date('daily_reward_time')->nullable();
            $table->bigInteger('weekly_reward_points')->nullable();
            $table->date('weekly_reward_time')->nullable();
            $table->bigInteger('bonus_reward_points')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reward_points');
    }
};
