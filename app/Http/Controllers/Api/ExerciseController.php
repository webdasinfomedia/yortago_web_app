<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DayResource;
use App\Http\Resources\ExerciseItemResource;
use App\Http\Resources\ExerciseListResource;
use App\Http\Resources\ExerciseResource;
use App\Http\Resources\DashboardExerciseResource;
use App\Http\Resources\FavouriteResource;
use App\Http\Resources\AlternateExerciseListResource;
use App\Http\Resources\TestingResource;
use App\Http\Traits\ExerciseTrait;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\ResponseTrait;
use App\Models\BodyPart;
use App\Models\Category;
use App\Models\ExerciseList;
use App\Models\AlternateExerciseList;
use App\Models\ExerciseStyle;
use App\Models\FormCheck;
use App\Models\Gender;
use App\Models\MobilityTest;
use App\Models\Monitoring;
use App\Models\NewExercise;
use App\Models\NewExerciseWeekDay;
use App\Models\NewExerciseWeekDayItem;
use App\Models\NewUserExerciseLog;
use App\Models\SpeedTest;
use App\Models\StaminaTest;
use App\Models\StrengthTest;
use App\Models\User;
use App\Models\NewUserExercise;
use App\Models\ExerciseNote;
use App\Models\UserSwap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Mail\FormCheckUploaded;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ExerciseController extends Controller
{
    //
    use ResponseTrait, ExerciseTrait, ImageUploadTrait;

    public function dashboard_exercises(Request  $request){
        $user = $request->user();
        //$exerciseCategory = $user->exercises()->with(['weeks.days.exerciseItems.exercise_list'])->first();

        // Get user's assigned exercises
        $myexercises = $user->exercises()
            ->withPivot(['start_date', 'completion_date'])
            ->wherePivot('user_id', $user->id)
            ->inRandomOrder()
            ->paginate(20);
       
        // Get generic exercises (type = 'generic' and not assigned to any user)
        $genericExercises = NewExercise::query()
            ->where('type', 'generic')
            // ->where('user_id', null)
            // ->whereDoesntHave('users')
            ->inRandomOrder()
            ->paginate(20);
        
        // REMOVE ADDITIONAL DATA LIKE WEEKS
        $exercises = NewExercise::query();

        // Filter exercises where 'user_id' is null
        $exercises = $exercises->inRandomOrder();
        
        // Uncomment this block if you want to filter by category
        // if ($exerciseCategory && $exerciseCategory->category_id) {
        //     $exercises = $exercises->where('category_id', $exerciseCategory->category_id);
        // }
        
        $exercises = $exercises->paginate(20);
        // Get a paginated list of favourite exercises (those that have a related 'favouriteExercise')
        $favouriteExerciseList = ExerciseList::select('id','image','body_part_id','name','weight','rest','video_link')->with('body_part')->whereHas('favouriteExercise', function($q){
            $q->where('user_id', auth()->user()->id);
        })->inRandomOrder()->paginate(20); 
        
        // Return the API response
        return $this->returnApiResponse(200, 'All exercises fetched successfully', [
            'my_exercises' => DashboardExerciseResource::collection($myexercises->values()), // User's assigned exercises
            'exercises' => DashboardExerciseResource::collection($exercises->values()), // Exercises with no user_id
            'generic_exercises' => DashboardExerciseResource::collection($genericExercises->values()), // Generic exercises
            'favourite_exercises' => FavouriteResource::collection($favouriteExerciseList->values()), // Favourite exercises
            'my_exercises_next_page_url' => $myexercises->nextPageUrl(),
            'generic_exercises_next_page_url' => $genericExercises->nextPageUrl(),
            'next_page_url' => $exercises->nextPageUrl(), // URL for the next page of exercises
        ]);
        
    }
    
    
    //my completed exercise programs
    public function mycompleted_exercises(Request  $request){
        $user = $request->user();
       
        // REMOVE ADDITIONAL DATA LIKE WEEKS
        $exercises = NewUserExercise::where('user_id', $user->id)->where('completion_date', '!=', null)->with(['exercise','logs']);
        
        $exercises = $exercises->paginate(20);
        
        // Return the API response
        return $this->returnApiResponse(200, 'My completed exercises fetched successfully', [
            'exercises' => $exercises, // Exercises with no user_id
            'next_page_url' => $exercises->nextPageUrl(), // URL for the next page of exercises
        ]);
        
    }

    public function all_exercises(Request $request)
    {
        $user = $request->user();
        // fetch all exercises that are not assigned to the user
        $exercises = NewExercise::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['weeks.days.exerciseItems.exercise_list']);
        if ($request->category_id) {
            $exercises = $exercises->where('category_id', $request->category_id);
        }
        $exercises = $exercises->where('user_id', null);
        $exercises = $exercises->paginate(1);
        return $this->returnApiResponse(200, 'All exercises fetched successfully', array('exercises' => ExerciseResource::collection($exercises->values()), 'next_page_url' => $exercises->nextPageUrl()));
    }

    public function my_exercises(Request $request)
    {
        $user = $request->user();

        if ($request->filled('exercise_id')) {
            // If exercise_id is provided, filter the exercises
            $exercises = $user->exercises()
                ->where('new_exercises.id', $request->exercise_id)
                ->with(['weeks.days.exerciseItems.exercise_list'])
                ->paginate(5);
        } else {
            // If exercise_id is not provided, return all exercises
            $exercises = $user->exercises()
                ->with(['weeks.days.exerciseItems.exercise_list'])
                ->paginate(5);
        }


        $request->merge(['show_logs' => true]);
        return $this->returnApiResponse(200, 'All exercises fetched successfully', array('exercises' => ExerciseResource::collection($exercises->values()), 'next_page_url' => $exercises->nextPageUrl()));
    }
   public function alternate_exercises(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'exercise_list_id' => 'required|exists:exercise_lists,id',
            'exercise_id' => 'required|exists:new_exercise_week_day_items,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a 400 error with validation error messages
            return $this->returnApiResponse(400, $validator->errors()->first(), []);
        }

        $alternate_exercises = AlternateExerciseList::where('new_exercise_week_day_item_id', $request->exercise_id)
            ->with(['body_part', 'exercise_style'])
            ->get();

        // Return using resource
        return $this->returnApiResponse(
            200, 
            'Alternate exercise fetched successfully', 
            AlternateExerciseListResource::collection($alternate_exercises)
        );
    }

    //swap_exercise and store in NewUserExerciseLog
    public function swap_exercise(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'id' => 'required|exists:new_exercise_week_day_items,id',
            'swap_id' => 'required|exists:new_exercise_week_day_items,id',
            'program_id' => 'required|exists:new_user_exercises,id',
        ]);

        $user = $request->user();
        // save in user_swaps table
        $log = UserSwap::create([
            //'user_id', 'exercise_item_id', 'new_item_id','new_user_exercise_id'
            'user_id' => $user->id,
            'exercise_item_id' => $data['id'],
            'new_item_id' => $data['swap_id'],
            'new_user_exercise_id' => $data['program_id']
        ]);
        //$request->merge(['show_logs' => true]);
        $exerciseData = $user->exercises()->wherePivot('id', $data['program_id'])->with(['weeks.days.exerciseItems.exercise_list'])->first();
        return $this->returnApiResponse(200, 'Exercise swapped successfully', array('swapped' => new ExerciseResource($exerciseData)));
    }

   public function log_exercise(Request $request)
    {
        // Validate the incoming request
        $data = $request->validate([
            'id' => 'required|exists:new_exercise_week_day_items,id',
            'sets' => 'required|array',
            'reps' => 'required|array',
            'weight' => 'nullable|array',
            'notes' => 'nullable|array',
            'program_id' => 'required|exists:new_user_exercises,id',
            'intensity' => 'required|string',
            'time_taken' => 'required',
            'weight_unit' => 'required',
            'body_part_id' => 'required',
            'status' => 'nullable|string',
            'alternate' => 'nullable|boolean',                    
            'alternate_exercise_id' => 'nullable|exists:alternate_exercise_lists,id' 
        ]);
       
       
        $user = $request->user();
    
        // Fetch the original exercise item
        $exerciseItem = NewExerciseWeekDayItem::find($data['id']);



        // Log the exercise or update if already exists
        $log = NewUserExerciseLog::updateOrCreate(
            [
                'user_id' => $user->id,
                'new_item_id' => $exerciseItem->id,
                'new_user_exercise_id' => $data['program_id'],
            ],
            [
                'sets' => json_encode($data['sets']),
                'reps' => json_encode($data['reps']),
                'weight' => key_exists('weight', $data) ? json_encode($data['weight']) : null,
                'weight_unit' => $data['weight_unit'],
                'notes' => $data['notes'] ?? null ? json_encode($data['notes']) : null,
                'intensity' => $data['intensity'],
                'time_taken' => $request->time_taken,
                'body_part_id' => $request->body_part_id,
                'status' => $data['status'] ?? 'completed',
                'alternate' => $data['alternate'] ?? false,                        
                'alternate_exercise_id' => $data['alternate_exercise_id'] ?? null, 
            ]
        );
        
        // Fetch the actual day model with its relations
        $day = NewExerciseWeekDay::with('exerciseItems.exercise_list')
            ->find($exerciseItem->new_exercise_week_day_id);
    
        // Attach the program_id to the day object
        $day->program_id = $data['program_id'];
        
        $exerciseData = $user->exercises()->wherePivot('id', $data['program_id'])->with(['weeks.days.exerciseItems.exercise_list'])->first();
        return $this->returnApiResponse(200, 'Exercise logged successfully', array('log' => new DayResource($day),'swapped' => new ExerciseResource($exerciseData)));
    }
    
    //get user exercise logs
    public function get_exercise_logs(Request $request)
    {
        $user = $request->user();
        $query = NewUserExerciseLog::where('user_id', $user->id);
    
        // Optional filter by new_item_id
        if ($request->has('new_item_id') && !empty($request->new_item_id)) {
            $query->where('new_item_id', $request->new_item_id);
        }
    
        $logs = $query->get();
    
        return $this->returnApiResponse(200, 'Exercise logs retrieved successfully', $logs);
    }
    
    //end program 

   public function program_end(Request $request)
    {
        $data = $request->validate([
            'program_id' => 'required|exists:new_user_exercises,id',
        ]);

        $user = $request->user();

        // Correct: use a query instead of find()->where()
        $program = NewUserExercise::where('id', $data['program_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$program) {
            return $this->returnApiResponse(404, 'Program not found', []);
        }

        $program->update([
            'completion_date' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Program completed successfully.',
            'data' => $program,
        ]);
    }

    //stroed exercise notes
   public function save_note(Request $request)
  {
        $data = $request->validate([
            'exercise_id' => 'required|exists:new_exercise_week_day_items,id',
            'program_id' => 'required|exists:new_user_exercises,id',
            'notes' => 'required|string',
        ]);

        $user = $request->user();

        $note = ExerciseNote::Create(
            [
                'user_id' => $user->id,
                'new_item_id' => $data['exercise_id'],
                'new_user_exercise_id' => $data['program_id'],
                'notes' => $data['notes'],
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Exercise note saved successfully.',
            'data' => $note
        ]);
    }
    
      //get exercise notes
     public function get_notes(Request $request)
    {
        $data = $request->validate([
            'exercise_id' => 'required|exists:new_exercise_week_day_items,id',
        ]);

        $user = $request->user();

        // Step 1: Find all exercise items for this day
        $exerciseItems = NewExerciseWeekDayItem::where('id', $data['exercise_id'])
            ->select('id', 'name', 'image', 'new_exercise_week_day_id')
            ->get();

        // Step 2: Build the response with exercises and their notes
        $formattedData = $exerciseItems->map(function ($exercise) use ($user) {
            // Fetch notes for this specific exercise
            $notes = ExerciseNote::where('user_id', $user->id)
                ->where('new_item_id', $exercise->id)
                ->get();

            // Format notes for this exercise
            $formattedNotes = $notes->map(function ($note) {
                return [
                    'note_id' => $note->id,
                    'notes' => $note->notes,
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            return [
                'exercise_id' => $exercise->id,
                'exercise_name' => $exercise->name,
                'exercise_image' => $exercise->image ? url($exercise->image) : null,
                'notes' => $formattedNotes,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Exercise notes retrieved successfully.',
            'data' => $formattedData,
        ]);
    }

    //get exercise notes
     public function get_day_notes(Request $request)
    {
        $data = $request->validate([
            'day_id' => 'required|exists:new_exercise_week_days,id',
        ]);

        $user = $request->user();

        // Step 1: Find all exercise items for this day
        $exerciseItems = NewExerciseWeekDayItem::where('new_exercise_week_day_id', $data['day_id'])
            ->select('id', 'name', 'image', 'new_exercise_week_day_id')
            ->get();

        // Step 2: Build the response with exercises and their notes
        $formattedData = $exerciseItems->map(function ($exercise) use ($user) {
            // Fetch notes for this specific exercise
            $notes = ExerciseNote::where('user_id', $user->id)
                ->where('new_item_id', $exercise->id)
                ->get();

            // Format notes for this exercise
            $formattedNotes = $notes->map(function ($note) {
                return [
                    'note_id' => $note->id,
                    'notes' => $note->notes,
                    'created_at' => $note->created_at->format('Y-m-d H:i:s'),
                ];
            });

            return [
                'exercise_id' => $exercise->id,
                'exercise_name' => $exercise->name,
                'exercise_image' => $exercise->image ? url($exercise->image) : null,
                'notes' => $formattedNotes,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Day-wise exercise notes retrieved successfully.',
            'data' => $formattedData,
        ]);
    }


    //delete note api 
    public function delete_note(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:exercise_notes,id',
        ]);

        $user = $request->user();

        $note = ExerciseNote::where('id', $data['id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$note) {
            return response()->json([
                'status' => false,
                'message' => 'Note not found or you are not authorized to delete it.',
            ], 404);
        }

        $note->delete();

        return response()->json([
            'status' => true,
            'message' => 'Exercise note deleted successfully.',
        ]);
    }

    //get all exerciseItems for a exercise

    public function getExerciseItems(Request $request)
    {
        $data = $request->validate([
            'exercise_id' => 'required|exists:new_exercises,id',
        ]);
        $exercise = NewExercise::find($data['exercise_id']);
        //get category of the exercise
        $category = $exercise->category_id;
        //get all exercises of the same category
        $exercises = NewExercise::where('category_id', $category)->get();
        $exerciseItems = $exercises->flatMap(function ($exercise) {
            return $exercise->weeks->flatMap(function ($week) {
                return $week->days->flatMap(function ($day) {
                    return $day->exerciseItems;
                });
            });
        });;
        return $this->returnApiResponse(200, 'Exercise items fetched successfully', array('exercise_items' => ExerciseItemResource::collection($exerciseItems)));
    }

    public function getExerciseItem(Request $request)
    {
        $exerciseItem = ExerciseList::orderBy('created_at', 'DESC');
        if ($request->body_part_id) {
            $exerciseItem = $exerciseItem->where('body_part_id', $request->body_part_id);
        }
        if ($request->exercise_style_id) {
            $exerciseItem = $exerciseItem->where('exercise_style_id', $request->exercise_style_id);
        }
        $exerciseItem = $exerciseItem->paginate(5);
        return $this->returnApiResponse(200, 'Exercise item fetched successfully', array('exercise_item' => ExerciseListResource::collection($exerciseItem->values()), 'next_page_url' => $exerciseItem->nextPageUrl()));
    }

    public function get_plans(Request $request)
    {
        $user = $request->user();
        // fetch all exercises that are not assigned to the user
        $exercises = NewExercise::with(['weeks.days.exerciseItems.exercise_list']);
        $exercises = $exercises->where('user_id', $user->id);
        $exercises = $exercises->paginate(1);
        return $this->returnApiResponse(200, 'All Plans fetched successfully', array('exercises' => ExerciseResource::collection($exercises->values()), 'next_page_url' => $exercises->nextPageUrl()));
    }

    public function create_plan(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'title' => 'required',
            'no_of_weeks' => 'required|integer',
        ]);
        $save = new NewExercise();
        $save->title = $request->title;
        $save->type = "private";
        $save->user_id = $user->id;
        $save->gender_id = "0";
        $save->equipment_id = "0";
        $save->experience_level_id = "0";
        $save->age_id = "0";
//        $save->category_id = "0";
        $save->save();
        $this->add_weeks_in_exercise($save->id, $request->no_of_weeks, 1);
        return $this->returnApiResponse(200, 'Plan created successfully', array());
    }

    public function add_day(Request $request)
    {
        $data = $request->validate([
            'week_id' => 'required|exists:new_exercise_weeks,id',
            'no_of_days' => 'required|integer',
        ]);
        $this->add_days_in_week($request->week_id, $data['no_of_days']);
        return $this->returnApiResponse(200, 'Day added successfully', array());
    }

    public function add_exercise(Request $request)
    {
        $data = $request->validate([
            'day_id' => 'required|exists:new_exercise_week_days,id',
            'exercise_id' => 'required|array',
        ]);
        foreach ($request->exercise_id as $exerciseId) {
            $exercise = ExerciseList::find($exerciseId);
            NewExerciseWeekDayItem::create([
                'new_exercise_week_day_id' => $data['day_id'],
                'exercise_list_id' => $exercise->id,
                'name' => $exercise->name,
                'sets' => 0,
                'reps' => 0,
                'rest' => 0,
                'tempo' => 0,
                'intensity' => 0,
                'weight' => 0,
                'video_link' => null,
                'image' => null,
                'notes' => '',
            ]);
        }
        return $this->returnApiResponse(200, 'Exercise added successfully', array());
    }

    public function categories(Request $request)
    {
        $categories = Category::all();
        return $this->returnApiResponse(200, 'Categories fetched successfully', array('categories' => $categories));
    }

    public function genders(Request  $request){
        $genders = Gender::all();
        return $this->returnApiResponse(200, 'Categories fetched successfully', array('genders' => $genders));
    }

    public function bodyparts(Request $request)
    {
        $bodyparts = BodyPart::all();
        return $this->returnApiResponse(200, 'Bodyparts fetched successfully', array('bodyparts' => $bodyparts));
    }

    public function exercise_style(Request $request)
    {
        $exercise_style = ExerciseStyle::all();
        return $this->returnApiResponse(200, 'Styles fetched successfully', array('styles' => $exercise_style));
    }

    public function testings(Request $request)
    {
        if (!in_array($request->type, $this->test_types())) {
            return $this->returnApiResponse(400, 'Invalid testing type', array());
        }
        $user = $request->user();
        if ($request->type == "speed_test") {
            $check = SpeedTest::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
        }
        if ($request->type == "mobility_test") {
            $check = MobilityTest::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
        }

        if ($request->type == "strength_test") {
            $check = StrengthTest::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
        }

        if ($request->type == "stamina_test") {
            $check = StaminaTest::where('user_id', $user->id)->orderBy('created_at','DESC')->get();
        }
        return $this->returnApiResponse(200, 'Testing fetched successfully', array('testing' => TestingResource::collection($check)));
    }

    public function form_check(Request $request)
    {
         // Validate the filter parameter
        $validator = Validator::make($request->all(), [
            'filter' => 'sometimes|in:today,this_month,this_year,all'
        ], [
            'filter.in' => 'Invalid filter parameter. Please use only: today, this_month, this_year, or all'
        ]);

        if ($validator->fails()) {
            return $this->returnApiResponse(400, $validator->errors()->first(), []);
        }
        $filter = $request->input('filter', 'all'); // default to 'all' if no filter provided
        
        $query = FormCheck::where('user_id', $request->user()->id);
        
        // Apply filters based on the filter parameter
        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
            case 'all':
            default:
                // No additional filter - return all records
                break;
        }
        
        $check = $query->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'file' => URL::to($item->file),
                    'reply' => $item->reply,
                    'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                    'reply_date_time' => $item->updated_at->format('Y-m-d H:i:s'),
                ];
            });
        
        $coach = User::where('role', 'admin')->first();
        $coachName = $coach->name ?? 'N/A';
        $coachImage = $coach ? (URL::to($coach->profile_pic) ?? $coach->profile_pic) : null;
        
        return $this->returnApiResponse(200, 'Form check fetched successfully', [
            'form_check' => $check,
            'coach_name' => $coachName,
            'coach_image' => $coachImage,
            'filter_applied' => $filter
        ]);
    }

    // public function save_form_check(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:jpeg,png,jpg,gif,mp4,mov,ogg,qt|max:20480',
    //     ]);
    //     $user = $request->user();
    //     $save = new FormCheck();
    //     $save->user_id = $user->id;
    //     $save->file = $this->upload_image($request->file('file'));
    //     $save->save();

    //     return $this->returnApiResponse(200, 'form check submitted', array());
    // }
     public function save_form_check(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,mp4,mov,ogg,qt|max:20480',
        ]);

        $user = $request->user();
        $save = new FormCheck();
        $save->user_id = $user->id;
        $save->file = $this->upload_image($request->file('file'));
        $save->save();

        // Notify admin
        $adminEmail = 'info@yortago.com'; 
        $videoUrl = url('uploads/' . $save->file);

       
          try {
            Mail::to($adminEmail)->send(new FormCheckUploaded($user, $videoUrl));
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            // Optional: show flash message or ignore silently
        }

        return $this->returnApiResponse(200, 'form check submitted', []);
    }

    public function monitoring(Request $request)
    {
        $user = $request->user();
        $monitoring = Monitoring::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        
        return $this->returnApiResponse(200, 'Monitoring fetched successfully', array('monitoring' => $monitoring));
    }

    public function exerciseDetailById(Request $request){

        $validator = Validator::make($request->all(), [
            'exercise_id' => 'required|integer|exists:new_exercises,id' // Checks if metric_id exists in the metrics table
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            // Return a 400 error with validation error messages
            return $this->returnApiResponse(400, $validator->errors()->first(),[] );
        }

        $exerciseDetails =  NewExercise::where('id',$request->exercise_id)->with(['weeks.days.exerciseItems.exercise_list'])->get();

        if($exerciseDetails){

            
            return $this->returnApiResponse(200, "Exercise Detials",
            array('exercises' => ExerciseResource::collection($exerciseDetails->values()))
            
        );
        }else{
            return $this->returnApiResponse(400, "Exercise detials not found", []);
        }
        

    }

}