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
        Schema::table('alternate_exercise_lists', function (Blueprint $table) {
            // Add nullable foreign key reference
            $table->unsignedBigInteger('new_exercise_week_day_item_id')->nullable()->after('exercise_list_id');

            // Foreign key constraint (optional but recommended)
            $table->foreign('new_exercise_week_day_item_id')
                ->references('id')
                ->on('new_exercise_week_day_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alternate_exercise_lists', function (Blueprint $table) {
            $table->dropForeign(['new_exercise_week_day_item_id']);
            $table->dropColumn('new_exercise_week_day_item_id');
        });
    }
};
