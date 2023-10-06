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
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('type')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('code')->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->enum('status',[0,1,2])->default(0)->nullable();
            $table->rememberToken();
            $table->timestamps();
//            $table->bigInteger('country_id')->unsigned()->nullable();
//            $table->bigInteger('city_id')->unsigned()->nullable();


//            $table->foreign('country_id')->references('id')->on('countries');
//            $table->foreign('city_id')->references('id')->on('cities');
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
