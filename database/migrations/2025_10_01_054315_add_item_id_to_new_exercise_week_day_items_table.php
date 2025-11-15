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
        Schema::table('new_exercise_week_day_items', function (Blueprint $table) {
            if (!Schema::hasColumn('new_exercise_week_day_items', 'item_id')) {
                $table->unsignedInteger('item_id')->nullable()->after('new_exercise_week_day_id')
                      ->comment('Exercise number inside the day');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_exercise_week_day_items', function (Blueprint $table) {
            if (Schema::hasColumn('new_exercise_week_day_items', 'item_id')) {
                $table->dropColumn('item_id');
            }
        });
    }
};
