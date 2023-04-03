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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('mission_title');
            $table->text('mission_description');
            $table->string('mission_proof_type');
            $table->bigInteger('number_of_referals_required');
            $table->bigInteger('referal_unit_point');
            $table->string('referal_code')->unique();
            $table->string('mission_start_date');
            $table->string('mission_end_date');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
