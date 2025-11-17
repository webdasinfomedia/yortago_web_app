<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
                Schema::create('alternate_exercise_item_pivot', function (Blueprint $table) {
                $table->id();
                $table->foreignId('alternate_exercise_list_id')
                    ->constrained('alternate_exercise_lists')
                    ->onDelete('cascade')
                    ->name('aeip_alt_ex_list_id_fk'); // shortened
                    
                $table->foreignId('new_exercise_week_day_item_id')
                    ->constrained('new_exercise_week_day_items')
                    ->onDelete('cascade')
                    ->name('aeip_new_ex_item_id_fk'); // shortened

                $table->integer('sets')->nullable();
                $table->integer('reps')->nullable();
                $table->integer('rest')->nullable();
                $table->string('tempo')->nullable();
                $table->string('intensity')->nullable();
                $table->string('weight')->nullable();
                $table->string('weight_value')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['alternate_exercise_list_id', 'new_exercise_week_day_item_id'], 'alternate_item_unique');
            });


    }

    public function down()
    {
        Schema::dropIfExists('alternate_exercise_item_pivot');
    }
};