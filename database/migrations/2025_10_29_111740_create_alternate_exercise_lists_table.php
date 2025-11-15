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
        Schema::create('alternate_exercise_lists', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('exercise_list_id'); // Reference to main exercise
            $table->string('name');
            $table->unsignedBigInteger('body_part_id');
            $table->unsignedBigInteger('exercise_style_id');
            $table->string('image')->nullable();
            $table->string('sets')->nullable();
            $table->string('reps')->nullable();
            $table->string('weight')->nullable();
            $table->string('weight_value')->nullable();
            $table->string('rest')->nullable();
            $table->string('tempo')->nullable();
            $table->string('intensity')->nullable();
            $table->string('video_link')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('exercise_list_id')->references('id')->on('exercise_lists')->onDelete('cascade');
            $table->foreign('body_part_id')->references('id')->on('body_parts')->onDelete('cascade');
            $table->foreign('exercise_style_id')->references('id')->on('exercise_styles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternate_exercise_lists');
    }
};
