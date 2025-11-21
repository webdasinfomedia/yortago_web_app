<?php

namespace App\Http\Traits;

use App\Models\NewExerciseWeek;
use App\Models\NewExerciseWeekDay;
use App\Models\User;
use App\Models\NewUserExercise;

trait ExerciseTrait
{

    public function add_weeks_in_exercise($exercise_id, $weeks, $days)
    {
        for ($i = 1; $i <= $weeks; $i++) {
            $exercise = new NewExerciseWeek();
            $exercise->new_exercise_id = $exercise_id;
            $exercise->week_number = $i;
            $exercise->save();
            if ($days > 0) {
                $this->add_days_in_week($exercise->id, $days);
            }

        }
    }

    public function add_days_in_week($week_id, $days,$title = null)
    {
        for ($i = 1; $i <= $days; $i++) {
            $exercise = new NewExerciseWeekDay();
            $exercise->new_exercise_week_id = $week_id;
            $exercise->day_number = $i;
//            $exercise->title = $title;
            $exercise->save();
        }
    }

    public function delete_weeks_in_exercise($id)
    {
        NewExerciseWeek::where('id', $id)
            ->delete();
    }

    public function delete_day_in_week($id)
    {
        NewExerciseWeekDay::where('id', $id)
            ->delete();
    }

    public function assign_exercise_to_user($user_id, $new_exercise_id, $start_date)
    {
        $user = User::find($user_id);
        $user->update(['is_assign' => true]);
        //$user->exercises()->detach();
        $user->exercises()->attach($new_exercise_id, ['start_date' => $start_date]);
    }

    public function deassign_exercise_to_user($user_id, $new_exercise_id)
    {
        $user = User::find($user_id);
        $user->update(['is_assign' => false]);
         
        NewUserExercise::where('user_id', $user_id)
        ->where('new_exercise_id', $new_exercise_id)
        ->delete();
        // $user->exercises()->detach($new_exercise_id);
    }

    public function updateExerciseDates($userId, $exerciseId, $startDate, $completionDate)
    {
        // Fetch the user
        $user = User::findOrFail($userId);

        // Update the pivot table with the new start and completion dates
        $user->exercises()->updateExistingPivot($exerciseId, [
            'start_date' => $startDate,
            'completion_date' => $completionDate,
        ]);
    }

    public function log_response($log)
    {
        return [
            'sets' => $log->sets,
            'reps' => $log->reps,
            'weight' => $log->weight,
            'logged_at' => $log->created_at->format('Y-m-d H:i:s'),
            'notes' => $log->notes,
            'swapped' => $log->replaced_item_id ? true : false,
            'replaced_item' => $log->replacedExerciseItem ? [
                'id' => $log->replacedExerciseItem->id,
                'name' => $log->replacedExerciseItem->name,
            ] : null,
        ];
    }

    public function test_fields()
    {
        return [
            'trail1',
            'trail2',
            'trail3',
            'calories_burn',
        ];
    }

    public function test_types()
    {
        return [
            'speed_test',
            'mobility_test',
            'strength_test',
            'stamina_test',
        ];
    }
}
