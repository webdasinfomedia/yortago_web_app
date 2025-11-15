<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExerciseProgramStatus;
use App\Models\ExerciseProgramVideo;
use App\Models\ExerciseProgramWeek;
use App\Models\User;
use App\Models\UserExerciseProgram;
use App\Models\UserExerciseProgramDay;
use App\Models\UserExerciseProgramWeek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserExerciseProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {


        $lists=User::whereHas('experience_level')->with('experience_level')->where('user_type','!=','Stream')->orderBy('id','desc')->get();

        return view('admin.users.list',get_defined_vars());
    }

    public function edit($id)
    {
      $item=User::with('exercise_weeks.exercise_days.exercise_infos')->find($id);

      $user_id=$id;
      $user=User::find($id);


        return view('admin.users.exercise-program.create',get_defined_vars());
    }

    public function saveVideo(Request $request)
    {


        if($request->hasFile('file')){

            if($request['upload_type']=="video"){
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = public_path().'/uploads/exercise/video';
                $orgPath=  $file->move($path, $filename);

                $file_name='uploads/exercise/video/'.$filename;

               $video= ExerciseProgramVideo::create([
                    'user_id'=>$request['exercise_id'],
                    'path'=>$file_name
                ]);

                return response([
                    "success"=>true,
                    "video"=>$video,
                     'message'=>"Video Upload Successfully"
                ]);
            }else{
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $path = public_path().'/uploads/exercise/images';
                $orgPath=  $file->move($path, $filename);

                $file_name='uploads/exercise/images/'.$filename;

               $video= ExerciseProgramVideo::create([
                    'user_id'=>$request['exercise_id'],
                    'path'=>$file_name
                ]);

                return response([
                    "success"=>true,
                    "video"=>$video,
                     'message'=>"Image Upload Successfully"
                ]);
            }



        }

        return response([
            "success"=>false,
             'message'=>"Video Failed to Upload "
        ]);
    }


    public function infoSave(Request $request)
    {

        try {

            DB::beginTransaction();
            $week = UserExerciseProgramWeek::where(['id' => $request->week_id ?? 0, 'user_id' => $request->user_id])->first();

            if ($week == null) {
                $weekId = UserExerciseProgramWeek::insertGetId([
                    'user_id' => $request->user_id,
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
                    $day_ids[$i] = UserExerciseProgramDay::insertGetId([
                            'day_name' => $name_array[$i],
                            'user_id' => $request->user_id,
                            'user_exercise_program_week_id' => $weekId,
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
            UserExerciseProgram::where(['user_id' => $request->user_id,'exercise_program_day_id' =>  $request->day_id])->delete();
            //dd($request->info);
            foreach ($request->info as $info) {
                UserExerciseProgram::insert(
                    [
                        'title' => $info['title'],
                        'exercise_program_day_id' =>  $request->day_id,
                        'user_id' => $request->user_id,
                        'video_path' => $info['video'],
                        'image_path' => $info['image'],
                        'description' => $info['description'] ?? null,
                        'sets' => $info['sets'],
                        'reps' => $info['reps'],
                        'temps' => $info['temp'],
                        'rest' => $info['rest'],
                        'intensity' => $info['intensity'],
                        'created_at' => Carbon::now(),
                        'weight_required' => $info['weight_required'] ?? 0
                    ]
                );
            }
            User::where('id',$request->user_id)->update(['is_approve_exercise_info'=>1]);
            terminate:
            DB::commit();
            return response()->json([ "success" => true, "message" => "Data Store Successfully",'week_id'=> $weekId,'day_id'=>$day_ids]);
        }catch (\Exception $e){
            dd($e->getMessage());
            DB::rollBack();
            return response()->json([ "success" => false, "message" => "SomeThing Went Wrong Please Try After Some Time" ]);
        }


    }


    public function infoSort(Request $request)
    {

        foreach ($request['order'] as $key => $sort) {
            UserExerciseProgram::find($sort['id'])->update([

                'order_no'=>$sort['position'],

            ]);
        }

        return Response([

            'status'=>true,
            'message'=>"Sort Successfully"

        ]);
    }
    public function WeekStatus(Request $request){


        UserExerciseProgramWeek::find($request->week_id)->update([
            'status'=>$request->status
        ]);
    }
    public function DeleteWeek($week_id){
        UserExerciseProgramWeek::find($week_id)->delete();
    }

}
