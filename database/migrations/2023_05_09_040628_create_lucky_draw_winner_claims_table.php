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
        Schema::create('lucky_draw_winner_claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lottery_id');
            $table->unsignedBigInteger('lucky_draw_id');
            $table->unsignedBigInteger('lucky_draw_winner_id');
            $table->unsignedBigInteger('ticket_no');
            $table->string('name');
            $table->text('address_1');
            $table->text('address_2')->nullable();
            $table->tinyInteger('status')->comment('1 claim,2 pending,3 approved,4 reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lucky_draw_winner_claims');
    }
};
