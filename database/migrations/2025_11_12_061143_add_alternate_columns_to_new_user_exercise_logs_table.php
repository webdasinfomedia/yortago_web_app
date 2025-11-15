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
        Schema::table('new_user_exercise_logs', function (Blueprint $table) {
             // Add a boolean column for alternate
            $table->boolean('alternate')->default(false)->after('status');

            // Add foreign key for alternate_exercise_id (related to alternate exercise)
            $table->unsignedBigInteger('alternate_exercise_id')->nullable()->after('alternate');

            // If the alternate exercise references the AlternateExerciseList model
            $table->foreign('alternate_exercise_id')
                ->references('id')
                ->on('alternate_exercise_lists')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_user_exercise_logs', function (Blueprint $table) {
            $table->dropForeign(['alternate_exercise_id']);
            $table->dropColumn(['alternate', 'alternate_exercise_id']);
        });
    }
};
