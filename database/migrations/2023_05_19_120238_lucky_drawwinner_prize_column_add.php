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
        Schema::table('lucky_draw_winners', function (Blueprint $table){
            $table->string('type');
            $table->decimal('amount',10,2)->nullable();
            $table->string('prize_name')->nullable()->change();
            $table->string('prize_image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lucky_draw_winners', function (Blueprint $table) {
            //
        });
    }
};