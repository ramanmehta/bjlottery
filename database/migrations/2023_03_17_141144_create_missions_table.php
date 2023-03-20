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
            $table->string('mission_description');
            $table->string('mission_proof_type');
            $table->integer('number_of_referals_required');
            $table->integer('referal_unit_point');
            $table->integer('referal_code')->unique();
            $table->dateTime('mission_start_date');
            $table->dateTime('mission_end_date');
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
