<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Monitoring;
use App\Models\NewUserExerciseLog;
use App\Models\BodyPart;
use App\Http\Resources\MonitoringResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ExerciseList;


class MonitoringController extends Controller
{
    use ResponseTrait;

    public function __construct()
    {
    
    }

    public function get(Request $request)
    {
        $user = $request->user();

        // Validate request parameters (optional but recommended)
        $request->validate([
            
        ]);
        $validator = Validator::make($request->all(), [
            'body_part_id' => 'required|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        if ($validator->fails()) {
            return $this->returnApiResponse(422, $validator->errors()->first(),[]);
        }

        $bodyPartId = $request->input('body_part_id');
        $query= NewUserExerciseLog::where('user_id', $user->id)
        ->whereHas('exerciseItem.exercise_list.body_part',function($query) use ($bodyPartId){
            $query->where('id',$bodyPartId);
        });
        
        // Apply start_date filter if provided
        if ($request->filled('start_date')) {
            $query->whereDate('updated_at', '>=', $request->input('start_date'));
        }

        // Apply end_date filter if provided
        if ($request->filled('end_date')) {
            $query->whereDate('updated_at', '<=', $request->input('end_date'));
        }

        // Fetch the records ordered by creation date
        $monitoring = $query->orderBy('updated_at', 'desc')->get();
        
        return $this->returnApiResponse(
            200,
            'Monitoring data fetched successfully',
             MonitoringResource::collection($monitoring)
        );
    }


    public function getBodyPartList(Request $request){

        $userId = auth()->user()->id;
 

        $bodyParts = BodyPart::whereHas('exerciseLists',function($query) use ($userId){
            $query->whereHas('exerciseDayItems', function($query) use ($userId){
                $query->whereHas('userExerciseLogs', function($query) use ($userId){
                    $query->where('user_id', $userId);
                });
            });
        })->get();
        

        return $this->returnApiResponse(200, 'Body parts data fetched successfully', $bodyParts
        );
    }
}
