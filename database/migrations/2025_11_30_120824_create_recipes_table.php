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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('ingredients'); // Store ingredients as JSON array
            $table->json('instructions'); // Store instructions as JSON array
            $table->string('image')->nullable(); // URL or path to the image
            $table->integer('cooking_time'); // in minutes
            $table->decimal('rating', 2, 1)->nullable(); // rating out of 5.0
            $table->enum('category', ['breakfast', 'lunch', 'dinner']);
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
