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
            // Add new 'status' column after 'body_part_id'
            $table->string('status', 50)->default('active')->after('body_part_id');

            // Modify 'notes' column to longText for multiple notes (JSON format)
            $table->longText('notes')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_user_exercise_logs', function (Blueprint $table) {
            // Rollback status column
            $table->dropColumn('status');

            // Revert notes column to original text type
            $table->text('notes')->nullable()->change();
        });
    }
};
