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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('description_facebook')->nullable();
            $table->string('name_facebook')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('description_youtube')->nullable();
            $table->string('name_youtube')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('description_twitter')->nullable();
            $table->string('name_twitter')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('description_instagram')->nullable();
            $table->string('name_instagram')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('description_linkedin')->nullable();
            $table->string('name_linkedin')->nullable();
            $table->string('link_linkedin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
