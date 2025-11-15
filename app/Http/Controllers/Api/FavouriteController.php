<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardExerciseResource;
use App\Http\Resources\ExerciseResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Favourite;
use App\Models\NewExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ExerciseList;

class FavouriteController extends Controller
{
    use ResponseTrait; 
    public function create(Request $request) {
        try{
            $validator = Validator::make($request->all(), [
                'exercise_id' => 'required|exists:exercise_lists,id',
            ]);
        
            if ($validator->fails()) {
                return $this->returnApiResponse(422, "Validation error", ['error' => $validator->errors()]);
            }
        
            $data = [
                "user_id" => auth()->user()->id,
                "exercise_id" => $request->exercise_id
            ];
        
            // Check if the exercise is already favourited by the user
            $existingFavourite = Favourite::where('user_id', auth()->user()->id)
                                          ->where('exercise_id', $request->exercise_id)
                                          ->first();
        
            if ($existingFavourite) {
                return $this->returnApiResponse(400, "This exercise is already favourited", $existingFavourite);
            }
        
            // Create the new favourite record
            $favourite = Favourite::create($data);
        
            return $this->returnApiResponse(200, "Exercise has been favourited", $favourite);
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }
    

    public function remove(Request $request){
        $validator = Validator::make($request->all(), [
            'exercise_id' => 'required|exists:exercise_lists,id',
        ]);
        if ($validator->fails()) {
            return $this->returnApiResponse(422, "Validation error", array('error' => $validator->errors()));
        }

        $favourite = Favourite::where(['user_id' => auth()->user()->id,'exercise_id' => $request->exercise_id ])->delete();
        if($favourite){
            return $this->returnApiResponse(200, "Exercise has been remove from favourite",[]);
        }else{
            return $this->returnApiResponse(400, "Favourite exercicse not found",[]);
        }
    }

    // public function getAll(){
    //     $exerciseList = NewExercise::whereHas('favouriteExercise', function($q){
    //         $q->where('user_id', auth()->user()->id);
    //     })->with(['weeks.days.exerciseItems.exercise_list'])->paginate(5);

    //     return $this->returnApiResponse(200, 'All favourite exercises fetched successfully', [            
    //         'favourite_exercises' => ExerciseResource::collection($exerciseList->values()), // Favourite exercises
    //         'next_page_url' => $exerciseList->nextPageUrl(), // URL for the next page of exercises
    //     ]);
    // }

    public function getAll(){
       return $exerciseList = ExerciseList::select('id','image','body_part_id','name','weight','rest','video_link')->with('body_part')->whereHas('favouriteExercise', function($q){
                    $q->where('user_id', auth()->user()->id);
                })->paginate(5); 
                
                //->with(['weeks.days.exerciseItems.exercise_list'])->paginate(5);
        
                // return $this->returnApiResponse(200, 'All favourite exercises fetched successfully', [            
                //     'favourite_exercises' => ExerciseResource::collection($exerciseList->values()), // Favourite exercises
                //     'next_page_url' => $exerciseList->nextPageUrl(), // URL for the next page of exercises
                // ]);
    }

    public function getExerciseByBodyPartId($bodyPartId){
     $exerciseList = ExerciseList::whereHas('favouriteExercise')->where('body_part_id', $bodyPartId)->paginate(5);

        return $this->returnApiResponse(200, 'All favourite exercises fetched successfully', $exerciseList);
    }
}
