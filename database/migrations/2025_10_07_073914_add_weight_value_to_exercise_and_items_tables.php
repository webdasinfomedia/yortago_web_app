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
          // Add to exercise_lists table
        Schema::table('exercise_lists', function (Blueprint $table) {
            $table->string('weight_value')->nullable()->after('weight');
        });

        // Add to new_exercise_week_day_items table
        Schema::table('new_exercise_week_day_items', function (Blueprint $table) {
            $table->string('weight_value')->nullable()->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercise_lists', function (Blueprint $table) {
            $table->dropColumn('weight_value');
        });

        Schema::table('new_exercise_week_day_items', function (Blueprint $table) {
            $table->dropColumn('weight_value');
        });
    }
};
