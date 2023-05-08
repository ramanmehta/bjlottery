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
        Schema::create('lucky_draw_winners', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('lottery_id');
            $table->unsignedInteger('lucky_draw_id');
            $table->string('ticket_no');
            $table->string('prize_name');
            $table->string('prize_image');
            $table->timestamps();
        });

        refered_by
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lucky_draw_winners');
    }
};
