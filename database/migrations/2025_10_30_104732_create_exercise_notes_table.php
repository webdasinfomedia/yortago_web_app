<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercise_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('new_item_id');
            $table->unsignedBigInteger('new_user_exercise_id');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('new_item_id')->references('id')->on('new_exercise_week_day_items')->onDelete('cascade');
            $table->foreign('new_user_exercise_id')->references('id')->on('new_user_exercises')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise_notes');
    }
};
