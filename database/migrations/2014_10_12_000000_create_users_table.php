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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            // $table->unsignedBigInteger('role_id');
            // $table->foreign('role_id')->references('id')->on('roles');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip');
            // $table->tinyInteger('status')->default(1);
            $table->enum('status', [0, 1])->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('logo')->nullable();
            $table->rememberToken();
            $table->bigInteger('today_gained_point')->default(0);
            $table->bigInteger('today_deduct_point')->default(0);
            $table->bigInteger('total_point_available')->default(0);
            $table->bigInteger('total_cash_available')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
