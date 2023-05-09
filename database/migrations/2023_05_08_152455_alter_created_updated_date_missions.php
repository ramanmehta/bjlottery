<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->string('proof')->nullable();
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->string('approval_status')->nullable()->after('proof');
        });
    }

    public function down()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn(['approval_status','proof']);
        });
    }
};
