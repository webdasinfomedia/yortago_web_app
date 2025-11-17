<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ExerciseTrait;
use App\Http\Traits\ImageUploadTrait;
use App\Models\BodyPart;
use App\Models\Category;
use App\Models\ExerciseList;
use App\Models\AlternateExerciseList;
use App\Models\ExerciseStyle;
use App\Models\FormCheck;
use App\Models\MobilityTest;
use App\Models\Monitoring;
use App\Models\SpeedTest;
use App\Models\StaminaTest;
use App\Models\StrengthTest;
use Illuminate\Http\Request;
use App\Http\Resources\MonitoringResource;
use App\Models\NewUserExerciseLog;
use App\Http\Traits\ResponseTrait;
use App\Models\Metric;
use App\Mail\FormCheckReply;
use Illuminate\Support\Facades\Mail;

class ExerciseListController extends Controller
{
    //
    use ImageUploadTrait, ExerciseTrait, ResponseTrait;

    public function exercise_list()
    {
        $exercise_lists = ExerciseList::all();

        return view('admin.exercise_list.manage', compact('exercise_lists'))->with('title', 'Manage Exercise List');
    }

    // Add this method to your existing ExerciseListController
    public function unified_management()
    {
        $categories = Category::all();
        $bodyparts = BodyPart::all();
        $exercise_styles = ExerciseStyle::all();
        $exercise_lists = ExerciseList::with('alternateExercises')
        ->with(['body_part', 'exercise_style'])
        ->orderBy('id', 'DESC')
        ->get();
        $metricsList = Metric::orderBy('created_at', 'DESC')->paginate(10);
        
        return view('admin.exercise_management.unified', compact(
            'categories', 'bodyparts', 'exercise_styles', 'exercise_lists', 'metricsList'
        ))->with('title', 'Exercise Management');
    }

    // Add this method for AJAX loading
    public function get_exercise_data($id)
    {
        $exercise = ExerciseList::findOrFail($id);
        return response()->json($exercise);
    }

     public function create_exercise_list()
    {
        $bodyparts = BodyPart::all();
        $exercise_styles = ExerciseStyle::all();
        return view('admin.exercise_list.create', get_defined_vars())->with('title', 'Create Exercise List');
    }

    public function save_exercise_list(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'body_part_id' => 'required',
            'exercise_style_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'weight_value'=>'nullable',
            'video_link' => 'required',
        ]);

        $exercise_list = new ExerciseList();
        $exercise_list->name = $request->name;
        $exercise_list->body_part_id = $request->body_part_id;
        $exercise_list->exercise_style_id = $request->exercise_style_id;
        
        if ($request->hasFile('image')) {
            $image = $this->upload_file($request->file('image'));
        } else {
            $image = null;
        }
        
        $exercise_list->image = $image;
        $exercise_list->sets = $request->sets;
        $exercise_list->reps = $request->reps;
        $exercise_list->rest = $request->rest;
        $exercise_list->tempo = $request->tempo;
        $exercise_list->intensity = $request->intensity;
        $exercise_list->weight = $request->weight;
        $exercise_list->weight_value = $request->weight_value ?? null;
        $exercise_list->video_link = $request->video_link;
        $exercise_list->notes = $request->notes;
        $exercise_list->save();

        // Redirect to edit page after creation to add alternate exercises
        return redirect()->route('admin.new.exercise.edit_exercise_list', ['id' => $exercise_list->id])
            ->with('message', 'Exercise List created successfully! You can now add alternative exercises.');
    }

    public function edit_exercise_list(Request $request)
    {
        $exercise_list = ExerciseList::findOrFail($request->id);
        $body_parts = BodyPart::all();
        $exercise_styles = ExerciseStyle::all();
        
        // Get alternate exercises for this exercise
        $alternate_exercises = AlternateExerciseList::where('exercise_list_id', $exercise_list->id)
            ->with(['body_part', 'exercise_style'])
            ->get();
        
        return view('admin.exercise_list.edit', get_defined_vars())->with('title', 'Edit Exercise List');
    }
      public function view_exercise_list(Request $request)
    {
        $exercise_list = ExerciseList::findOrFail($request->id);
        $body_parts = BodyPart::all();
        $exercise_styles = ExerciseStyle::all();
        
        // Get alternate exercises for this exercise
        $alternate_exercises = AlternateExerciseList::where('exercise_list_id', $exercise_list->id)
            ->with(['body_part', 'exercise_style'])
            ->get();
        
        return view('admin.exercise_list.view', get_defined_vars())->with('title', 'View Exercise List');
    }

     public function update_exercise_list(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'body_part_id' => 'required',
            'exercise_style_id' => 'required',
            'weight_value'=>'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_link' => 'required',
        ]);

        $exercise_list = ExerciseList::findOrFail($request->id);
        $exercise_list->name = $request->name;
        $exercise_list->body_part_id = $request->body_part_id;
        $exercise_list->exercise_style_id = $request->exercise_style_id;
        
        if ($request->hasFile('image')) {
            $image = $this->upload_file($request->file('image'));
            $exercise_list->image = $image;
        }

        $exercise_list->video_link = $request->video_link;
        $exercise_list->sets = $request->sets;
        $exercise_list->reps = $request->reps;
        $exercise_list->rest = $request->rest;
        $exercise_list->tempo = $request->tempo;
        $exercise_list->intensity = $request->intensity;
        $exercise_list->weight = $request->weight;
        $exercise_list->weight_value = $request->weight_value ?? null;
        $exercise_list->notes = $request->notes;
        $exercise_list->save();

        return redirect()->back()->with('message', 'Exercise List updated successfully!');
    }

    /**Create alternate exercise lists */
    public function save_alternate_exercise(Request $request)
    {
        $request->validate([
            'exercise_list_id' => 'required|exists:exercise_lists,id',
            'name' => 'required',
            'body_part_id' => 'required',
            'exercise_style_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'weight_value' => 'nullable',
            'video_link' => 'required',
        ]);

        $alternate_exercise = new AlternateExerciseList();
        $alternate_exercise->exercise_list_id = $request->exercise_list_id;
        $alternate_exercise->name = $request->name;
        $alternate_exercise->body_part_id = $request->body_part_id;
        $alternate_exercise->exercise_style_id = $request->exercise_style_id;
        
        if ($request->hasFile('image')) {
            $image = $this->upload_file($request->file('image'));
        } else {
            $image = null;
        }
        
        $alternate_exercise->image = $image;
        $alternate_exercise->sets = $request->sets;
        $alternate_exercise->reps = $request->reps;
        $alternate_exercise->rest = $request->rest;
        $alternate_exercise->tempo = $request->tempo;
        $alternate_exercise->intensity = $request->intensity;
        $alternate_exercise->weight = $request->weight;
        $alternate_exercise->weight_value = $request->weight_value ?? null;
        $alternate_exercise->video_link = $request->video_link;
        $alternate_exercise->notes = $request->notes;
        $alternate_exercise->save();

        return redirect()->back()->with('message', 'Alternate Exercise created successfully!');
    }

    /**Update alternate exercise lists */
    public function update_alternate_exercise(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:alternate_exercise_lists,id',
            'exercise_list_id' => 'required|exists:exercise_lists,id',
            'name' => 'required',
            'body_part_id' => 'required',
            'exercise_style_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'weight_value' => 'nullable',
            'video_link' => 'required',
        ]);

        $alternate_exercise = AlternateExerciseList::findOrFail($request->id);
        $alternate_exercise->exercise_list_id = $request->exercise_list_id;
        $alternate_exercise->name = $request->name;
        $alternate_exercise->body_part_id = $request->body_part_id;
        $alternate_exercise->exercise_style_id = $request->exercise_style_id;
        
        if ($request->hasFile('image')) {
            $image = $this->upload_file($request->file('image'));
            $alternate_exercise->image = $image;
        }
        
        $alternate_exercise->sets = $request->sets;
        $alternate_exercise->reps = $request->reps;
        $alternate_exercise->rest = $request->rest;
        $alternate_exercise->tempo = $request->tempo;
        $alternate_exercise->intensity = $request->intensity;
        $alternate_exercise->weight = $request->weight;
        $alternate_exercise->weight_value = $request->weight_value ?? null;
        $alternate_exercise->video_link = $request->video_link;
        $alternate_exercise->notes = $request->notes;
        $alternate_exercise->save();

        return redirect()->back()->with('message', 'Alternate Exercise updated successfully!');
    }

    /**Get alternate exercise lists */
    public function get_alternate_exercises($exerciseId)
    {
        $exercise = ExerciseList::findOrFail($exerciseId);
        $alternates = AlternateExerciseList::with(['body_part', 'exercise_style'])
            ->where('exercise_list_id', $exerciseId)
            ->get();
        
        return response()->json([
            'main_exercise_name' => $exercise->name,
            'alternates' => $alternates
        ]);
    }
    
    public function get_alternate_exercise($id)
    {
        $alternate_exercise = AlternateExerciseList::findOrFail($id);
        return response()->json($alternate_exercise);
    }
   
    /**Delete alternate exercise lists */
    public function delete_alternate_exercise($id)
    {
        $alternate = AlternateExerciseList::findOrFail($id);
        $alternate->delete();
        
        return response()->json(['success' => true, 'message' => 'Alternate exercise deleted successfully']);
    }

    public function delete_exercise_list(Request $request)
    {
        $exercise_list = ExerciseList::findOrFail($request->id);
        
        // Delete all alternate exercises first
        AlternateExerciseList::where('exercise_list_id', $exercise_list->id)->delete();
        
        $exercise_list->delete();

        return redirect()->back()->with('message', 'Exercise List deleted successfully!')->with('active_tab', 'exercise-list');
    }

    public function testing_type(Request $request)
    {
        if (!in_array($request->type, $this->test_types())) {
            abort(404);
        }
        $title = ucfirst(str_replace('_', ' ', $request->type));
        $testing_fields = $this->test_fields();
        if ($request->type == "speed_test") {
            $check = SpeedTest::where('user_id', $request->id)->get();
        }
        if ($request->type == "mobility_test") {
            $check = MobilityTest::where('user_id', $request->id)->get();
        }

        if ($request->type == "strength_test") {
            $check = StrengthTest::where('user_id', $request->id)->get();
        }

        if ($request->type == "stamina_test") {
            $check = StaminaTest::where('user_id', $request->id)->get();
        }
        return view('admin.users.testing', compact('testing_fields', 'check'))->with('title', $title);
    }

    public function save_testing(Request $request)
    {
        if ($request->type == "speed_test") {

            $save = new SpeedTest();
            $save->user_id = $request->user_id;
            foreach ($this->test_fields() as $field) {
                $save->$field = $request->$field;
            }
            $save->save();
        }
        if ($request->type == "mobility_test") {
            $save = new MobilityTest();
            $save->user_id = $request->user_id;
            foreach ($this->test_fields() as $field) {
                $save->$field = $request->$field;
            }
            $save->save();
        }

        if ($request->type == "strength_test") {
            $save = new StrengthTest();
            $save->user_id = $request->user_id;
            foreach ($this->test_fields() as $field) {
                $save->$field = $request->$field;
            }
            $save->save();
        }

        if ($request->type == "stamina_test") {
            $save = new StaminaTest();
            $save->user_id = $request->user_id;
            foreach ($this->test_fields() as $field) {
                $save->$field = $request->$field;
            }
            $save->save();
        }
        return redirect()->back()->with('message', 'Test updated successfully!');
    }

    public function delete_testing(Request $request)
    {
        if ($request->type == "speed_test") {
            SpeedTest::where('id', $request->id)->delete();
        }
        if ($request->type == "mobility_test") {
            MobilityTest::where('id', $request->id)->delete();
        }

        if ($request->type == "strength_test") {
            StrengthTest::where('id', $request->id)->delete();
        }

        if ($request->type == "stamina_test") {
            StaminaTest::where('id', $request->id)->delete();
        }
        return redirect()->back()->with('message', 'Test deleted successfully!');
    }

    public function monitoring(Request $request)
    {
        // $items = ['Body Fat','Stamina','Other'];
        // $monitoring = Monitoring::where('user_id', $request->id)->get();
        $userId = $request->id;
        $items = BodyPart::whereHas('exerciseLists',function($query) use ($userId){
            $query->whereHas('exerciseDayItems', function($query) use ($userId){
                $query->whereHas('userExerciseLogs', function($query) use ($userId){
                    $query->where('user_id', $userId);
                });
            });
        })->get();
        return view('admin.users.monitoring', compact('items'))->with('title', "Goal Tracking");
    }
    
    public function getMonitoringData($userId, $bodyPartId)
    {
        $data = NewUserExerciseLog::where('user_id', $userId)
        ->whereHas('exerciseItem.exercise_list.body_part',function($query) use ($bodyPartId){
            $query->where('id',$bodyPartId);
        })->orderBy('updated_at', 'desc')->get();
        return json_encode(MonitoringResource::collection($data));
        // return view('admin.users.monitoring_data', compact('list'));
    }

    public function save_monitoring(Request $request)
    {
        $request->validate([
            'value' => 'required',
            'type' => 'required',
        ]);

        $save = new Monitoring();
        $save->user_id = $request->user_id;
        $save->value = $request->value;
        $save->type = $request->type;
        $save->save();
        return redirect()->back()->with('message', 'Goal Tracking updated successfully!');
    }

    public function delete_monitoring(Request $request)
    {
        Monitoring::where('id', $request->id)->delete();
        return redirect()->back()->with('message', 'Goal Tracking deleted successfully!');
    }

    public function form_check(Request $request)
    {
        $form_check = FormCheck::where('user_id', $request->id)->orderBy('created_at','desc')->get();
        return view('admin.users.form_check', compact('form_check'))->with('title', "Form Check");
    }

    // public function save_form_check(Request $request)
    // {
    //     $request->validate([
    //         'reply' => 'required'
    //     ]);

    //     FormCheck::where('id', $request->id)->update([
    //         'reply' => $request->reply
    //     ]);
    //     return redirect()->back()->with('message', 'Form Check updated successfully!');
    // }
    public function save_form_check(Request $request)
    {
        $request->validate([
            'reply' => 'required'
        ]);

        $formCheck = FormCheck::findOrFail($request->id);
        
        $formCheck->update([
            'reply' => $request->reply
        ]);
        $videoUrl = url('/' . $formCheck->file);

        // Notify user
        $user = $formCheck->user;
        // Mail::to($user->email)->send(new FormCheckReply($user, $formCheck->reply, $videoUrl));
        try {
            Mail::to($user->email)->send(new FormCheckReply($user, $formCheck->reply, $videoUrl));
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            // Optional: show flash message or ignore silently
        }

        return redirect()->back()->with('message', 'Form Check updated successfully!');
    }


}
