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
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn(['mission_proof_type','number_of_share','per_share_point','mission_start_date','mission_end_date']);
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->string('mission_type');
            $table->string('enter_earn_affliated_points')->nullable();
            $table->string('prize_name')->nullable();
            $table->text('prize_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('missions', function (Blueprint $table) {
            //
        });
    }
};
