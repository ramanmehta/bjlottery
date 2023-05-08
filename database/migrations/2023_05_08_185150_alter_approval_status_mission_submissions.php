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
        Schema::table('mission_submissions', function (Blueprint $table) {
            $table->string('approval_status')->nullable()->after('proof');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mission_submissions', function (Blueprint $table) {
            $table->dropColumn('approval_status');
        });
    }
};
