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
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('month_id')->unsigned()->nullable();
            $table->string('sympol')->nullable();#name
            $table->integer('reached_min')->nullable();
            $table->integer('reached_max')->nullable();
            $table->string('target')->nullable();#int
            $table->string('comment')->nullable();#int
            $table->timestamps();

            $table->foreign('month_id')->references('id')->on('months');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
