<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->date('mission_start_date')->nullable()->change();
            $table->date('mission_end_date')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->date('mission_start_date')->change();
            $table->date('mission_end_date')->change();
        });
    }
};
