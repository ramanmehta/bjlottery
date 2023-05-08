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
        Schema::create('referal_points', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('referal_code')->unique();
            $table->string('referal_link')->unique();
            $table->bigInteger('referal_point')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referal_points');
    }
};
