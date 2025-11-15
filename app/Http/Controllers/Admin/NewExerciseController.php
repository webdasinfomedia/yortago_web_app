<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ExerciseTrait;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\Age;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\ExerciseList;
use App\Models\ExerciseProgram;
use App\Models\ExperienceLevel;
use App\Models\Gender;
use App\Models\NewExercise;
use App\Models\NewExerciseWeek;
use App\Models\NewExerciseWeekDay;
use App\Models\NewExerciseWeekDayItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewExerciseController extends Controller
{
    //
    use ResponseTrait, ExerciseTrait, ImageUploadTrait;

    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function manage_exercise()
    {
        \Log::info('manage');
        // $lists = NewExercise::whereHas('age')->whereHas('gender')->whereHas('experience_level')->orderBy('id', 'desc')->get();
        $lists = NewExercise::orderBy('id', 'desc')->get();
        return view('admin.new_exercise.manage', get_defined_vars())->with('title', 'Manage Exercise');
    }

    public function create_exercise_program(Request $request)
    {
        $ages = Age::all();
        $experience_levels = ExperienceLevel::all();
        $genders = Gender::all();
        $equipment = Equipment::all();
        $categories = Category::all();
        if ($request->id) {
            $program = NewExercise::find(decrypt($request->id));
            $title = 'Edit Exercise Program'; // Title for edit
        } else {
            $title = 'Create Exercise Program'; // Title for create
        }
    
        return view('admin.new_exercise.create_program', get_defined_vars())->with('title', $title);
        
    }

    public function add_title(Request $request)
    {
        $day = NewExerciseWeekDay::findOrFail($request->day_id);
        return view('admin.new_exercise.day_title', get_defined_vars())->with('title', 'Create Title');
    }

    public function update_title(Request $request)
    {
        NewExerciseWeekDay::where('id', $request->day_id)->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'duration' => $request->duration
        ]);
        return $this->returnWebResponse('Day title added Successfully', 'success');
    }

    public function assign_exercise(Request $request)
    {
        $exercise = NewExercise::findOrFail(decrypt($request->id));
        $assigned_users = $exercise->users;

        //get user list that are not assigned to this exercise by relationship
        $users = User::whereDoesntHave('exercises', function ($query) use ($exercise) {
            $query->where('new_exercise_id', $exercise->id);
        })->where('role', 'user')->orderBy('id', 'desc')->get();
       

        return view('admin.new_exercise.assign', get_defined_vars())->with('title', 'Assign Exercise');
    }

    public function assign_program(Request $request)
    {
        $exercise = NewExercise::findOrFail($request->new_exercise_id);
        if($request->user_id == null){
            return $this->returnWebResponse('Please select a user', 'error');
        }
        if(isset($exercise->id)){
            $this->assign_exercise_to_user($request->user_id, $exercise->id, Carbon::now()->toDateTimeString());
             return back()->with('message', 'Exercise Program Assigned Successfully');
            //return $this->returnWebResponse('Exercise Program Assigned Successfully', 'success');
        }else{
            return $this->returnWebResponse('Exercise Program not Assigned', 'error');
        }
       
    }

    public function checkUserExerciseExistanceById(Request $request)
    {
        $userId = $request->user_id;

        // Ensure the user exists
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the user has exercises
        $exists = $user->exercises()->exists();

        return response()->json(['exists' => $exists]);
    }

    

    public function deassign_program(Request $request)
    {
        $exercise = NewExercise::findOrFail($request->new_exercise_id);
        $this->deassign_exercise_to_user($request->user_id, $exercise->id);
         return back()->with('message', 'Exercise Program Deassigned Successfully');
        //return $this->returnWebResponse('Exercise Program Deassigned Successfully', 'success');
    }

    public function save_create_program(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:new_exercises,title',
            'category_id' => 'required|integer',
            'youtube_link' => 'nullable|url',
            'type' => 'required|in:generic,premium',
        ]);
        
        $imageURL = null;
        if($request->image)
        {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            $imageURL = $this->upload_file($request->file('image'));
        }

        $save = new NewExercise();
        $save->title = $request->title;
        $save->type = $request->type;
        $save->category_id = $request->category_id;
        $save->image = $imageURL;
        $save->youtube_link = $request->youtube_link;
        $save->save();
        
      
        //$this->add_weeks_in_exercise($save->id, 1, 1);
        return $this->redirectBackWebResponseWithParam('admin.new.exercise.create_exercise', array('id' => encrypt($save->id)), 'Exercise Program Created Successfully', 'success');
    }

    //
    public function update_create_program(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required|integer',
            'youtube_link' => 'nullable|url',
            'type' => 'required|in:generic,premium',
        ]);

        $save = NewExercise::find($request->id);
        $save->title = $request->title;
         $save->type = $request->type;
        $save->category_id = $request->category_id;
        if ($request->hasFile('image')) {
            $imageURL = $this->upload_file($request->file('image'));
            $save->image = $imageURL;
        }
        $save->youtube_link = $request->youtube_link;
        $save->save();
        
      
       // $this->add_weeks_in_exercise($save->id, 1, 1);
        // return $this->returnWebResponse( 'Exercise Program Created Successfully', 'success');
        return redirect('/admin/new/exercise/manage')->with('message', 'Exercise Program Updated Successfully');
    }

    public function create_exercise(Request $request)
    {
        $exercise = null;
        $title = 'Create Exercise';

        if ($request->has('id')) {
            $exercise = NewExercise::findOrFail(decrypt($request->id));

            // Only show "Edit Exercise" when coming from the actual Edit button
            if ($request->query('from') === 'edit') {
                $title = 'Edit Exercise';
            }
        }

        return view('admin.new_exercise.create_exercise', compact('exercise', 'title'));
    }


    /**
 * Create default structure with 1 week, 7 days, and 6 exercises per day
 */
    // private function createDefaultExerciseStructure($exerciseId)
    // {
    //     // Get first exercise from exercise list for default
    //     $defaultExerciseList = ExerciseList::first();
        
    //     // Create default week
    //     $week = NewExerciseWeek::create([
    //         'new_exercise_id' => $exerciseId
    //     ]);

    //     // Create 7 default days
    //     $dayTitles = [
    //         'Push Day - Chest, Shoulders, Triceps',
    //         'Pull Day - Back, Biceps',
    //         'Leg Day - Quads, Hamstrings, Glutes',
    //         'Upper Body - Arms & Core',
    //         'Lower Body - Legs & Glutes',
    //         'Full Body Workout',
    //         'Active Recovery'
    //     ];

    //     for ($i = 1; $i <= 7; $i++) {
    //         $day = NewExerciseWeekDay::create([
    //             'new_exercise_week_id' => $week->id,
    //             'title' => $dayTitles[$i-1] ?? "Day $i Workout",
    //             'summary' => "Complete workout for day $i",
    //             'duration' => '45-60 minutes'
    //         ]);

    //         // Create 6 default exercises per day
    //         $defaultExercises = $this->getDefaultExercisesForDay($i);
            
    //         foreach ($defaultExercises as $index => $exerciseData) {
    //             NewExerciseWeekDayItem::create([
    //                 'new_exercise_week_day_id' => $day->id,
    //                 'exercise_list_id' => $defaultExerciseList ? $defaultExerciseList->id : null,
    //                 'name' => $exerciseData['name'],
    //                 'sets' => $exerciseData['sets'],
    //                 'reps' => $exerciseData['reps'],
    //                 'rest' => $exerciseData['rest'],
    //                 'tempo' => $exerciseData['tempo'],
    //                 'intensity' => $exerciseData['intensity'],
    //                 'weight' => $exerciseData['weight'],
    //                 'notes' => $exerciseData['notes']
    //             ]);
    //         }
    //     }
    // }

    /**
     * Get default exercises based on day number
     */
    // private function getDefaultExercisesForDay($dayNumber)
    // {
    //     $exerciseTemplates = [
    //         1 => [ // Push Day
    //             ['name' => 'Bench Press', 'sets' => '4', 'reps' => '8-10', 'rest' => '90s', 'tempo' => '2-1-2-1', 'intensity' => 'High', 'weight' => 'Yes', 'notes' => 'Primary chest exercise. Focus on controlled movement.'],
    //             ['name' => 'Shoulder Press', 'sets' => '3', 'reps' => '10-12', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Keep core engaged throughout movement.'],
    //             ['name' => 'Incline Dumbbell Press', 'sets' => '3', 'reps' => '10-12', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Target upper chest muscles.'],
    //             ['name' => 'Lateral Raises', 'sets' => '3', 'reps' => '12-15', 'rest' => '45s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Isolate shoulder muscles.'],
    //             ['name' => 'Tricep Dips', 'sets' => '3', 'reps' => '10-15', 'rest' => '45s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'No', 'notes' => 'Can be assisted or weighted as needed.'],
    //             ['name' => 'Push-ups', 'sets' => '2', 'reps' => '15-20', 'rest' => '30s', 'tempo' => '2-1-2-1', 'intensity' => 'Low', 'weight' => 'No', 'notes' => 'Bodyweight finishing exercise.']
    //         ],
    //         2 => [ // Pull Day
    //             ['name' => 'Pull-ups', 'sets' => '4', 'reps' => '6-10', 'rest' => '90s', 'tempo' => '2-1-2-1', 'intensity' => 'High', 'weight' => 'No', 'notes' => 'Primary back exercise. Use assistance if needed.'],
    //             ['name' => 'Barbell Rows', 'sets' => '4', 'reps' => '8-10', 'rest' => '90s', 'tempo' => '2-1-2-1', 'intensity' => 'High', 'weight' => 'Yes', 'notes' => 'Keep back straight and core engaged.'],
    //             ['name' => 'Lat Pulldowns', 'sets' => '3', 'reps' => '10-12', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Focus on lat engagement.'],
    //             ['name' => 'Cable Rows', 'sets' => '3', 'reps' => '12-15', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Squeeze shoulder blades together.'],
    //             ['name' => 'Bicep Curls', 'sets' => '3', 'reps' => '12-15', 'rest' => '45s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Control the negative movement.'],
    //             ['name' => 'Face Pulls', 'sets' => '2', 'reps' => '15-20', 'rest' => '30s', 'tempo' => '2-1-2-1', 'intensity' => 'Low', 'weight' => 'Yes', 'notes' => 'Great for rear delt and posture.']
    //         ],
    //         3 => [ // Leg Day
    //             ['name' => 'Squats', 'sets' => '4', 'reps' => '8-10', 'rest' => '2min', 'tempo' => '3-1-1-1', 'intensity' => 'High', 'weight' => 'Yes', 'notes' => 'Primary leg exercise. Go deep and control the movement.'],
    //             ['name' => 'Romanian Deadlifts', 'sets' => '4', 'reps' => '8-10', 'rest' => '90s', 'tempo' => '3-1-2-1', 'intensity' => 'High', 'weight' => 'Yes', 'notes' => 'Focus on hip hinge movement.'],
    //             ['name' => 'Leg Press', 'sets' => '3', 'reps' => '12-15', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Full range of motion.'],
    //             ['name' => 'Walking Lunges', 'sets' => '3', 'reps' => '20 steps', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Alternate legs with each step.'],
    //             ['name' => 'Calf Raises', 'sets' => '3', 'reps' => '15-20', 'rest' => '45s', 'tempo' => '2-2-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Pause at the top of movement.'],
    //             ['name' => 'Leg Curls', 'sets' => '2', 'reps' => '12-15', 'rest' => '45s', 'tempo' => '2-1-2-1', 'intensity' => 'Low', 'weight' => 'Yes', 'notes' => 'Focus on hamstring contraction.']
    //         ]
    //     ];

    //     // For days 4-7, create variations or use day 1-3 patterns
    //     $defaultPattern = [
    //         ['name' => 'Compound Exercise', 'sets' => '4', 'reps' => '8-10', 'rest' => '90s', 'tempo' => '2-1-2-1', 'intensity' => 'High', 'weight' => 'Yes', 'notes' => 'Primary movement for this session.'],
    //         ['name' => 'Secondary Exercise', 'sets' => '3', 'reps' => '10-12', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Supporting movement.'],
    //         ['name' => 'Accessory Exercise 1', 'sets' => '3', 'reps' => '12-15', 'rest' => '60s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Isolation or accessory work.'],
    //         ['name' => 'Accessory Exercise 2', 'sets' => '3', 'reps' => '12-15', 'rest' => '45s', 'tempo' => '2-1-2-1', 'intensity' => 'Moderate', 'weight' => 'Yes', 'notes' => 'Additional accessory work.'],
    //         ['name' => 'Conditioning Exercise', 'sets' => '2', 'reps' => '15-20', 'rest' => '30s', 'tempo' => '1-1-1-1', 'intensity' => 'Low', 'weight' => 'No', 'notes' => 'Light conditioning work.'],
    //         ['name' => 'Mobility/Flexibility', 'sets' => '2', 'reps' => '30s hold', 'rest' => '30s', 'tempo' => 'Static', 'intensity' => 'Low', 'weight' => 'No', 'notes' => 'Stretching and mobility work.']
    //     ];

    //     return $exerciseTemplates[$dayNumber] ?? $defaultPattern;
    // }

    /**
     * Copy entire exercise program
     */
    public function copy_exercise_program(Request $request)
    {
        $originalExercise = NewExercise::with(['weeks.days.exerciseItems'])->findOrFail(decrypt($request->id));
        
        // Create new exercise program
        $newExercise = $originalExercise->replicate();
        $newExercise->title = $originalExercise->title . ' (Copy)';
        $newExercise->push();

        // Copy all weeks, days, and exercises
        foreach ($originalExercise->weeks as $week) {
            $newWeek = $week->replicate();
            $newWeek->new_exercise_id = $newExercise->id;
            $newWeek->save();

            foreach ($week->days as $day) {
                $newDay = $day->replicate();
                $newDay->new_exercise_week_id = $newWeek->id;
                $newDay->save();

                foreach ($day->exerciseItems as $exercise) {
                    $newExerciseItem = $exercise->replicate();
                    $newExerciseItem->new_exercise_week_day_id = $newDay->id;
                    $newExerciseItem->save();
                }
            }
        }

        return $this->redirectBackWebResponseWithParam(
            'admin.new.exercise.create_exercise', 
            ['id' => encrypt($newExercise->id)], 
            'Exercise Program Copied Successfully', 
            'success'
        );
    }

    /**
     * Bulk update exercises
     */
    public function bulk_update_exercises(Request $request)
    {
        $exercises = $request->input('exercises', []);
        
        foreach ($exercises as $exerciseData) {
            if (isset($exerciseData['id'])) {
                NewExerciseWeekDayItem::where('id', $exerciseData['id'])
                    ->update([
                        'exercise_list_id' => $exerciseData['exercise_list_id'],
                        'sets' => $exerciseData['sets'],
                        'reps' => $exerciseData['reps'],
                        'rest' => $exerciseData['rest'],
                        'tempo' => $exerciseData['tempo'],
                        'intensity' => $exerciseData['intensity'],
                        'weight' => $exerciseData['weight'],
                        'notes' => $exerciseData['notes']
                    ]);
            }
        }

        return $this->returnWebResponse('Exercises updated successfully', 'success');
    }

    public function save_day_exercise_item(Request $request)
    {
        $exercises = $request->all();

        //dd($exercises);

        foreach ($exercises['exercise_id'] as $index => $exerciseId) {
            if (!empty($exerciseId)) {
                // Update existing exercise if the ID is present
                $exercise = NewExerciseWeekDayItem::where('id', $exerciseId)->where('new_exercise_week_day_id', $exercises['day_id'][$index])->first();
                //dd($exercise);
                if ($exercise) {
                    if (isset($exercises['video_link'][$index])) {
                        //upload else keep the old one
                        $video_link = $this->upload_file($exercises['video_link'][$index]);
                    } else {
                        $video_link = $exercise->video_link;
                    }
                    if (isset($exercises['image'][$index])) {
                        //upload else keep the old one
                        $image = $this->upload_file($exercises['image'][$index]);
                    } else {
                        $image = $exercise->image;
                    }

                    $exercise->update([
                        'new_exercise_week_day_id' => $exercises['day_id'][$index],
                        'exercise_list_id' => $exercises['exercise_list_id'][$index],
                        'name' => "0",
                        'sets' => $exercises['sets'][$index],
                        'reps' => $exercises['reps'][$index],
                        'rest' => $exercises['rest'][$index],
                        'tempo' => $exercises['tempo'][$index],
                        'intensity' => $exercises['intensity'][$index],
                        'weight' => $exercises['weight'][$index],
                        'video_link' => $video_link,
                        'image' => $image,
                        'notes' => $exercises['notes'][$index] ?? " ",
                    ]);
                }
            } else {
                if (isset($exercises['video_link'][$index])) {
                    //upload else keep the old one
                    $video_link = $this->upload_file($exercises['video_link'][$index]);
                } else {
                    $video_link = null;
                }
                if (isset($exercises['image'][$index])) {
                    //upload else keep the old one
                    $image = $this->upload_file($exercises['image'][$index]);
                } else {
                    $image = null;
                }
                // Create new exercise if ID is empty
                NewExerciseWeekDayItem::create([
                    'new_exercise_week_day_id' => $exercises['day_id'][$index],
                    'exercise_list_id' => $exercises['exercise_list_id'][$index],
                    'name' => "0",
                    'sets' => $exercises['sets'][$index],
                    'reps' => $exercises['reps'][$index],
                    'rest' => $exercises['rest'][$index],
                    'tempo' => $exercises['tempo'][$index],
                    'intensity' => $exercises['intensity'][$index],
                    'weight' => $exercises['weight'][$index],
                    'video_link' => $video_link,
                    'image' => $image,
                    'notes' => $exercises['notes'][$index] ?? " ",
                ]);
            }
        }
        return $this->returnWebResponse('Exercise Item Added Successfully', 'success');
    }

    public function delete_item(Request $request)
    {
        $item = NewExerciseWeekDayItem::findOrFail($request->id);
        $item->delete();
        return $this->returnWebResponse('Exercise Item Deleted Successfully', 'success');
    }

    public function add_days_or_weeks(Request $request)
    {

        if ($request->type == "week") {
            $this->add_weeks_in_exercise(decrypt($request->id), 1, 0);
        }
        if ($request->type == "day") {

            $this->add_days_in_week($request->id, 1, '');
        }
        $messageString = ucfirst($request->type);
        return $this->returnWebResponse("$messageString created Successfully", 'success');

    }

    public function delete_days_or_weeks(Request $request)
    {
        if ($request->type == "week") {
            $this->delete_weeks_in_exercise($request->id);
        }
        if ($request->type == "day") {
            $this->delete_day_in_week($request->id);
        }
        $messageString = ucfirst($request->type);
        return $this->returnWebResponse("$messageString deleted Successfully", 'success');
    }
    
    public function duplicate_exercise($id)
    {
        $e = NewExercise::findOrFail($id);
        
        $relationships = [
            'weeks' => [
                'days' => [
                    'exerciseItems' => []
                ]
            ]
        ];
        
        $this->replicateWithNestedRelations($e, $relationships);
        return $this->returnWebResponse("Exercise Program Replicated Successfully", 'success');
    }
    
    private function replicateWithNestedRelations($model, $relationships) {
        // Replicate the main model
        $newModel = $model->replicate();
        $newModel->push();
    
        // Loop through each relationship to handle nested replication
        foreach ($relationships as $relation => $nestedRelations) {
            if ($model->$relation() instanceof \Illuminate\Database\Eloquent\Relations\HasMany) {
                foreach ($model->$relation as $related) {
                    // Recursively replicate each related model and its own relationships
                    $newRelated = $this->replicateWithNestedRelations($related, $nestedRelations);
                    $newRelated->{$model->$relation()->getForeignKeyName()} = $newModel->id;
                    $newRelated->save();
                }
            }
            // Add more relationship types if needed
        }
    
        return $newModel;
    }
    
    public function delete($eid)
    {
        $exc = NewExercise::findOrFail($eid);
        $exc->delete();
        
        return $this->returnWebResponse("Exercise Program Deleted Successfully", 'success');
    }

    // Add this method to your NewExerciseController.php class

/**
 * Show duplicate program interface
 */
public function duplicate_exercise_program(Request $request)
{
   $exercise = NewExercise::findOrFail($request->id);

    // if ($exercise->weeks->isEmpty()) {
    //     $this->createDefaultExerciseStructure($exercise->id);
    // }

    return view('admin.new_exercise.duplicate_program', [
        'encryptedId' => encrypt($exercise->id), // pass encrypted ID
        'title' => 'Duplicate Exercise Program',
    ]);
}

/**
 * Process duplication via AJAX/API endpoint
 */
public function process_duplicate_program(Request $request)
{
    $request->validate([
        'source_exercise_id' => 'required|integer|exists:new_exercises,id',
        'selected_days' => 'required|array|min:1',
        'duplicate_type' => 'required|in:new,existing',
        'target_week_position' => 'required|integer|min:1|max:12'
    ]);

    if ($request->duplicate_type === 'new') {
        $request->validate([
            'new_program_title' => 'required|string|max:255',
            'new_program_category_id' => 'required|integer|exists:categories,id'
        ]);
        
        return $this->duplicateToNewProgram($request);
    } else {
        $request->validate([
            'target_exercise_id' => 'required|integer|exists:new_exercises,id'
        ]);
        
        return $this->duplicateToExistingProgram($request);
    }
}

private function duplicateToNewProgram($request)
{
    $sourceExercise = NewExercise::findOrFail($request->source_exercise_id);
    
    // Create new exercise program
    $newExercise = NewExercise::create([
        'title' => $request->new_program_title,
        'type' => $sourceExercise->type,
        'category_id' => $request->new_program_category_id,
        'image' => $sourceExercise->image
    ]);

    // Create empty weeks if target position > 1
    for ($weekNum = 1; $weekNum < $request->target_week_position; $weekNum++) {
        $emptyWeek = NewExerciseWeek::create([
            'new_exercise_id' => $newExercise->id
        ]);

        // Create 7 empty days
        $this->createDefaultDaysForWeek($emptyWeek->id, $weekNum);
    }

    // Group selected days by week and duplicate them
    $this->duplicateSelectedDays($request->selected_days, $newExercise->id, $request->target_week_position);

    return response()->json([
        'success' => true,
        'message' => 'Program duplicated successfully!',
        'redirect_url' => route('admin.new.exercise.create_exercise', ['id' => encrypt($newExercise->id)])
    ]);
}

private function duplicateToExistingProgram($request)
{
    $targetExercise = NewExercise::findOrFail($request->target_exercise_id);
    
    // Create empty weeks up to target position if needed
    $existingWeeksCount = $targetExercise->weeks()->count();
    
    for ($weekNum = $existingWeeksCount + 1; $weekNum < $request->target_week_position; $weekNum++) {
        $emptyWeek = NewExerciseWeek::create([
            'new_exercise_id' => $request->target_exercise_id
        ]);

        $this->createDefaultDaysForWeek($emptyWeek->id, $weekNum);
    }

    // Duplicate selected days to existing program
    $this->duplicateSelectedDays($request->selected_days, $request->target_exercise_id, $request->target_week_position);

    return response()->json([
        'success' => true,
        'message' => 'Days duplicated to existing program successfully!',
        'redirect_url' => route('admin.new.exercise.create_exercise', ['id' => encrypt($request->target_exercise_id)])
    ]);
}

private function duplicateSelectedDays($selectedDayIds, $targetExerciseId, $startingWeekPosition)
{
    // Get selected days with their week information
    $selectedDays = NewExerciseWeekDay::whereIn('id', $selectedDayIds)
        ->with(['week', 'exerciseItems'])
        ->orderBy('id')
        ->get();

    // Group days by their original week
    $daysByWeek = $selectedDays->groupBy('new_exercise_week_id');
    
    $currentWeekPosition = $startingWeekPosition;
    
    foreach ($daysByWeek as $originalWeekId => $daysInWeek) {
        // Create new week for this group of days
        $newWeek = NewExerciseWeek::create([
            'new_exercise_id' => $targetExerciseId
        ]);

        // Duplicate each day in this week
        foreach ($daysInWeek as $originalDay) {
            $newDay = NewExerciseWeekDay::create([
                'new_exercise_week_id' => $newWeek->id,
                'title' => $originalDay->title,
                'summary' => $originalDay->summary,
                'duration' => $originalDay->duration
            ]);

            // Duplicate all exercises for this day
            foreach ($originalDay->exerciseItems as $originalExercise) {
                NewExerciseWeekDayItem::create([
                    'new_exercise_week_day_id' => $newDay->id,
                    'exercise_list_id' => $originalExercise->exercise_list_id,
                    'name' => $originalExercise->name,
                    'sets' => $originalExercise->sets,
                    'reps' => $originalExercise->reps,
                    'rest' => $originalExercise->rest,
                    'tempo' => $originalExercise->tempo,
                    'intensity' => $originalExercise->intensity,
                    'weight' => $originalExercise->weight,
                    'notes' => $originalExercise->notes,
                    'video_link' => $originalExercise->video_link,
                    'image' => $originalExercise->image
                ]);
            }
        }
        
        $currentWeekPosition++;
    }
}

private function createDefaultDaysForWeek($weekId, $weekNumber)
{
    $dayTitles = [
        'Push Day - Chest, Shoulders, Triceps',
        'Pull Day - Back, Biceps',
        'Leg Day - Quads, Hamstrings, Glutes',
        'Upper Body - Arms & Core',
        'Lower Body - Legs & Glutes',
        'Full Body Workout',
        'Active Recovery'
    ];

    for ($dayNumber = 1; $dayNumber <= 7; $dayNumber++) {
        NewExerciseWeekDay::create([
            'new_exercise_week_id' => $weekId,
            'title' => $dayTitles[$dayNumber - 1],
            'summary' => "Complete workout for day {$dayNumber}",
            'duration' => '45-60 minutes'
        ]);
    }
}
}
