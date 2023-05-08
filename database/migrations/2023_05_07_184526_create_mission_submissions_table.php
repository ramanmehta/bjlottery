<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mission_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mission_id');
            $table->unsignedBigInteger('user_id');
            $table->string('proof');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mission_submissions');
    }
};
