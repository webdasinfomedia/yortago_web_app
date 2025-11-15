<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Age;
use App\Models\Equipment;
use App\Models\ExerciseProgram;
use App\Models\ExerciseProgramDay;
use App\Models\ExerciseProgramInfo;
use App\Models\ExerciseProgramVideo;
use App\Models\ExerciseProgramWeek;
use App\Models\ExperienceLevel;
use App\Models\Gender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use VideoThumbnail;

use App\Models\UserExerciseProgram;
use App\Models\UserExerciseProgramDay;
use App\Models\UserExerciseProgramWeek;


class ExerciseProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }


    public function index(Request $request)
    {



        $ages=Age::all();
        $experience_levels=ExperienceLevel::all();
        $genders=Gender::all();
        $equipment=Equipment::all();

        $lists=ExerciseProgram::whereHas('age')->whereHas('gender')->whereHas('experience_level')->orderBy('id','desc')->get();
        return view('admin.exerciseprogram.list',get_defined_vars());
    }

    public function edit($id)
    {
        $item=ExerciseProgram::with('exercise_weeks.exercise_days.exercise_infos')->where('uniqid',$id)->first();
      //  dd($item->exercise_weeks[9]);

        return view('admin.exerciseprogram.create',get_defined_vars());
    }


    public function save(Request $request)
    {



        $request->validate([
            'gender_id' => 'required',
            'age_id' => 'required',
            'experience_id' => 'required',
            'equipment_id' => 'required',
            'name' => 'sometimes|string',

            'password' => 'sometimes|min:6',
            'type' => 'sometimes|in:private'
        ]);
        if($request->program_type==1){
            $request->validate([
                'email' => 'sometimes|email|unique:users',
            ]);
        }

        
        if($request->exercise_program)
            $exercise_program = ExerciseProgram::with('exercise_weeks.exercise_days.exercise_infos')->find($request->exercise_program);
        else
            $exercise_program = ExerciseProgram::where('age_id', $request['age_id'])->where('gender_id', $request['gender_id'])->where('experience_level_id', $request['experience_id'])->where('equipment_id', $request['equipment_id'])->first();
        
        // if($exercise_program!=null){
        //     session()->flash('warning','Exercise Program with this Specification already exist PLease edit it');
        // }
        if (!$exercise_program) {
            $exercise_program = ExerciseProgram::create([
                'title'=>$request->title,
                'age_id' => $request->age_id,
                'gender_id' => $request->gender_id,
                'experience_level_id' => $request->experience_id,
                'equipment_id' => $request->equipment_id,
                'uniqid' => uniqid()
            ]);
        }

        if (isset($request->type) && strtolower($request->program_type) == "1" && isset($request->name) && isset($request->email) && isset($request->password)) {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => 'private',
                'gender_id' => $request->gender_id,
                'age_id' => $request->age_id,
                'experience_level_id'=> $request->experience_id,
                'equipment_id' => $request->equipment_id,
                'is_approve_exercise_info' => 1,
            ]);
            
            foreach ($exercise_program['exercise_weeks'] as $key => $week) {
                $weekSave=UserExerciseProgramWeek::create([
                    "week_name"=>$week['week_name'],
                    "user_id"=>$user->id
                ]);
                foreach ($week['exercise_days'] as $key => $exercise_days) {
                    $savedDay=UserExerciseProgramDay::create([
                        "day_name"=>$exercise_days['day_name'],
                        "user_exercise_program_week_id"=>$weekSave['id'],
                        "user_id"=>$user->id
                    ]);

                    foreach ($exercise_days['exercise_infos'] as $key => $exercise_infos) {
                        UserExerciseProgram::create([
                            'user_id'=>$user->id,
                            'exercise_program_id'=>$exercise_infos['id'],
                            'exercise_program_day_id'=>$savedDay['id'],
                            'title'=>$exercise_infos['title'],
                            'video_path'=>$exercise_infos['video_path'],
                            'image_path'=>$exercise_infos['image_path'],
                            'description'=>$exercise_infos['description'],
                            'sets'=>$exercise_infos['sets'],
                            'reps'=>$exercise_infos['reps'],
                            'time'=>$exercise_infos['time'],
                            'temps'=>$exercise_infos['temps'],
                            'rest'=>$exercise_infos['rest'],
                            'intensity'=>$exercise_infos['intensity'],
                            'weight_required'=>$exercise_infos['weight_required'],
                        ]);
                    }
                }
            }
            DB::commit();
        }
        if($request->program_type==0){
        return redirect()->route('admin.exercise.program.edit', $exercise_program['uniqid']);
        }

        return redirect()->route('admin.users.edit', $user->id);
    }

    public function infoSave(Request $request)
    {
        try {

            DB::beginTransaction();
            $week = ExerciseProgramWeek::where(['id' => $request->week_id ?? 0, 'exercise_program_id' => $request->exercise_program_id])->first();

            if ($week == null) {
                $weekId = ExerciseProgramWeek::insertGetId([
                    'exercise_program_id' => $request->exercise_program_id,
                    'week_name' => $request->week_name,
                    'created_at' => Carbon::now(),
                ]);
            } else {
                $weekId = $week->id;
            }

            $day_ids = [];
            if (!$request->day_id) {

                $name_array = ['', 'Day One', 'Day Two', 'Day Three', 'Day Four', 'Day Five', 'Day Six', 'Day Seven'];

                for ($i = 1; $i <= 7; $i++) {
                    $day_ids[$i] = ExerciseProgramDay::insertGetId([
                            'day_name' => $name_array[$i],
                            'exercise_program_id' => $request->exercise_program_id,
                            'exercise_program_week_id' => $weekId,
                            'created_at' => Carbon::now(),
                        ]
                    );
                }
                if(!$request->day_id){
                    goto terminate;
                }
                $request->day_id = $day_ids[$request->day_name];
            } else {
                $day_ids = [$request->day_name => $request->day_id];
            }

            ExerciseProgramInfo::where(['exercise_program_day_id' => $request->day_id])->delete();
            //dd($request->info);
            foreach ($request->info as $info) {
                ExerciseProgramInfo::insert(
                    [
                        'title' => $info['title'],
                        'exercise_program_day_id' =>  $request->day_id,
                        'exercise_program_id' =>  $request->exercise_program_id,
                        'video_path' => $info['video'],
                        'image_path' => $info['image'],
                        'description' => $info['description'] ?? null,
                        'sets' => $info['sets'],
                        'reps' => $info['reps'],
                        'temps' => $info['temp'],
                        'rest' => $info['rest'],
                        'intensity' => $info['intensity'],
                        'created_at' => Carbon::now(),
                        'weight_required'=>$info['weight_required'] ?? 0,
                    ]
                );
            }
            terminate:
            DB::commit();
            return response()->json([ "success" => true, "message" => "Data Store Successfully",'week_id'=> $weekId,'day_id'=>$day_ids]);
        }catch (\Exception $e){
            DB::rollBack();

            return response()->json([ "success" => false, "message" => "SomeThing Went Wrong Please Try After Some Time" ]);
        }


    }

    public function infoSave1(Request $request)
    {

        ExerciseProgramInfo::where('exercise_program_id', $request['exercise_program_id'])->delete();
        ExerciseProgramWeek::where('exercise_program_id', $request['exercise_program_id'])->delete();
        ExerciseProgramDay::where('exercise_program_id', $request['exercise_program_id'])->delete();

        foreach ($request['weeks'] as $key => $week) {

            ExerciseProgramWeek::create([
                "week_name" => $week,
                "exercise_program_id" => $request['exercise_program_id']
            ]);
        }

        foreach ($request['days'] as $key => $day) {

            $days = (explode("_", $day));

            $week = ExerciseProgramWeek::where('exercise_program_id', $request['exercise_program_id'])->where('week_name', $days[0])->first();
            if (isset($week)) {

                $savedDay = ExerciseProgramDay::create([
                    "day_name" => str_replace("D-", "Day ", $days[1]),
                    "exercise_program_week_id" => $week['id'],
                    "exercise_program_id" => $request['exercise_program_id']
                ]);

                if (isset($request['title_' . $day])) {

                    foreach ($request['title_' . $day] as $key => $value) {

                        $description = "";
                        if (isset($request['description_' . $day][$key])) {
                            $description = $request['description_' . $day][$key][0];
                        }



                        if (($request['title_' . $day][$key][0] != null)) {
                            ExerciseProgramInfo::create([
                                'exercise_program_id' => $request['exercise_program_id'],
                                'exercise_program_day_id' => $savedDay['id'],
                                'title' => $request['title_' . $day][$key][0] ?? null,
                                'description' => $description,
                                'video_path' => $request['video_' . $day][$key][0] ?? null,
                                'image_path' => $request['image_' . $day][$key][0] ?? null,
                                'sets' => $request['sets_' . $day][$key][0] ?? null,
                                'reps' => $request['reps_' . $day][$key][0] ?? null,
                                'temps' => $request['temp_' . $day][$key][0] ?? null,
                                'rest' => $request['rest_' . $day][$key][0] ?? null,
                                'intensity' => $request['intensity_' . $day][$key][0] ?? null,
                            ]);
                        }
                    }
                    // return 1;
                }
            }
        }

        // return redirect()->back()->with('message','Exercise Program Info has been added');

        return response()->json([
            "success" => true,
            "message" => "Data Store Successfully",

        ]);
    }

    public function saveVideo(Request $request)
    {


        if ($request->hasFile('file')) {

            if ($request['upload_type'] == "video") {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = 'uploads/video';
                $orgPath =  $file->move($path, $filename);

                $file_name = 'uploads/video/' . $filename;

                $video = ExerciseProgramVideo::create([
                    'exercise_id' => $request['exercise_id'],
                    'path' => $file_name
                ]);

                return response([
                    "success" => true,
                    "video" => $video,
                    'message' => "Video Upload Successfully"
                ]);
            } else {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = 'uploads/images';
                $orgPath =  $file->move($path, $filename);

                $file_name = 'uploads/images/' . $filename;

                $video = ExerciseProgramVideo::create([
                    'exercise_id' => $request['exercise_id'],
                    'path' => $file_name
                ]);

                return response([
                    "success" => true,
                    "video" => $video,
                    'message' => "Image Upload Successfully"
                ]);
            }
        }

        return response([
            "success" => false,
            'message' => "Video Failed to Upload "
        ]);
    }

    public function infoSort(Request $request)
    {

        foreach ($request['order'] as $key => $sort) {
            ExerciseProgramInfo::find($sort['id'])->update([

                'order_no' => $sort['position'],

            ]);
        }

        return Response([

            'status' => true,
            'message' => "Sort Successfully"

        ]);
    }

    public function statusChange(Request $request)
    {
        ExerciseProgram::find($request['id'])->update([
            "status" => $request['status']
        ]);


        return true;
    }
    public function delete($id)
    {
        $exercise = ExerciseProgram::find($id);
        $exercise->delete();

        return back()->with('message', 'Exercise program deleted');
    }

    public function AddNewWeek(Request $request){
        $weekId = ExerciseProgramWeek::insertGetId([
            'exercise_program_id' => $request->exercise_program_id,
            'week_name' => $request->week_name,
            'created_at' => Carbon::now(),
        ]);
        return $weekId;
    }

    public function WeekStatus(Request $request){


        ExerciseProgramWeek::find($request->week_id)->update([
           'status'=>$request->status
        ]);
    }
    public function DeleteWeek($week_id){
        ExerciseProgramWeek::find($week_id)->delete();
    }
    
    public function updateTitle(Request $request)
    {
        $prog = ExerciseProgram::findOrFail($request->id);
        $prog->title = $request->title;
        $prog->save();
    }
}
