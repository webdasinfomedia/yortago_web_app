<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Age;
use App\Models\Equipment;
use App\Models\ExperienceLevel;
use App\Models\Gender;
use App\Models\Nutrition;
use App\Models\NutritionWeek;
use App\Models\NutritionWeekInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NutritionProgramController extends Controller
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

        $lists=Nutrition::whereHas('age')->whereHas('gender')->whereHas('experience_level')->orderBy('id','desc')->get();
        return view('admin.nutrition.list',get_defined_vars());
    }

    public function save(Request $request)
    {


        $request->validate([
            'gender_id'=>'required',
            'age_id'=>'required',
            'experience_id'=>'required',
            'equipment_id'=>'required',

        ]);

        $exists=Nutrition::where('age_id',$request['age_id'])->where('gender_id',$request['gender_id'])->where('experience_level_id',$request['experience_id'])->where('equipment_id',$request['equipment_id'])->first();

        if(isset($exists)){

            return redirect()->route('admin.nutrition.program.edit',$exists['uniqid']);

        }
        else{
            $exercise_program=Nutrition::create([
                'age_id'=>$request->age_id,
                'gender_id' => $request->gender_id,
                'experience_level_id' => $request->experience_id,
                'equipment_id' => $request->equipment_id,
                'uniqid' => uniqid()

            ]);
            return redirect()->route('admin.nutrition.program.edit',$exercise_program['uniqid']);
        }





    }


    public function edit($id)
    {
      $item=Nutrition::where('uniqid',$id)->with('nutrition_weeks.nutrition_infos')->first();
        return view('admin.nutrition.create',get_defined_vars());
    }

    public function infoSave(Request $request)
    {

        // return $request;





        NutritionWeek::where('nutrition_id',$request['id'])->delete();


        if(isset($request['week_0'])){
            foreach ($request['week_0'] as $key => $value) {
                $weeks=  NutritionWeek::create([
                    "nutrition_id"=>$request['id'],
                    'weak_name'=>$value
                ]);

                foreach ($request['heading_0'] as $key1=> $heading) {




                    $path=null;
                    if(isset($request['image_0'][$key1])){
                        $p_image=$request['image_0'][$key1];

                        $ex_path = "uploads/nutrition/";

                        $name=$p_image->getClientOriginalName();
                        $p_image->move('uploads/nutrition/', $name);

                        $path= "uploads/nutrition/".$name;





                }




                    NutritionWeekInfo::create([
                        "nutrition_week_id"=>$weeks['id'],
                        'heading'=>$heading,
                        'image'=>$path,
                        'suggestion'=>$request['suggestion_0'][$key1],
                        'nutrition_advice'=>$request['description_0'][$key1]
                    ]);
                }
            }
        }



        if(isset($request['week'])){
            foreach ($request['week'] as $key=> $value) {







                $weeks=  NutritionWeek::create([
                        "nutrition_id"=>$request['id'],
                        'weak_name'=>$value[0]
                    ]);

                    if(isset($request['heading'.str_replace(" ","_",$key)])){
                        foreach ($request['heading'.str_replace(" ","_",$key)] as $key1=> $heading) {

                            $description="";

                           if(isset($request['description'.str_replace(" ","_",$key)][$key1][0])){
                            $description=$request['description'.str_replace(" ","_",$key)][$key1][0];
                           }
                           $path=null;


                           if(isset($request['image'.str_replace(" ","_",$key)][$key1])){

                              $images = $request['image'.str_replace(" ","_",$key)][$key1];

                              foreach($images as $p_image){
                                $ex_path = "uploads/nutrition/";

                               $name=$p_image->getClientOriginalName();
                               $p_image->move('uploads/nutrition/', $name);

                               $path= "uploads/nutrition/".$name;


                              }


                           }
                           if($path==null){
                            if(isset($request['images'.str_replace(" ","_",$key)][$key1])){

                                $path=$request['images'.str_replace(" ","_",$key)][$key1][0];

                            }

                           }




                            NutritionWeekInfo::create([
                                "nutrition_week_id"=>$weeks['id'],
                                'heading'=>$heading[0],
                                'suggestion'=>$request['suggestion'.str_replace(" ","_",$key)][$key1][0],
                                'nutrition_advice'=>$description,
                                'image'=>$path,
                            ]);


                        }
                    }else if(isset($request['heading'.(string)$key])){
                        foreach ($request['heading'.(string)$key] as $key1=> $heading) {

                            $description="";

                           if(isset($request['description'.str_replace(" ","_",$key)][$key1][0])){
                            $description=$request['description'.str_replace(" ","_",$key)][$key1][0];
                           }

                           $path=null;

                           if(isset($request['image'.str_replace(" ","_",$key)][$key1][0])){
                            $p_image=$request['image'.str_replace(" ","_",$key)][$key1][0];

                            $ex_path = "uploads/nutrition/";

                            $name=$p_image->getClientOriginalName();
                            $p_image->move('uploads/nutrition/', $name);

                            $path= "uploads/nutrition/".$name;





                    }


                        //    return $heading;

                            NutritionWeekInfo::create([
                                "nutrition_week_id"=>$weeks['id'],
                                'heading'=>$heading[0],
                                'suggestion'=>$request['suggestion'.str_replace(" ","_",$key)][$key1][0],
                                'nutrition_advice'=>$description,
                                'image'=>$path,
                            ]);


                        }
                    }
                    else{
                        foreach ($request['headings'.(string)$key] as $key1=> $heading) {

                            $description="";

                           if(isset($request['descriptions'.str_replace(" ","_",$key)][$key1])){
                            $description=$request['descriptions'.str_replace(" ","_",$key)][$key1];
                           }
                           $path=null;
                           $path=null;
                        //    return $request['image'.str_replace(" ","_",$key)];

                           if(isset($request['image'.str_replace(" ","_",$key)][$key1])){
                            $p_image=$request['image'.str_replace(" ","_",$key)][$key1];

                            $ex_path = "uploads/nutrition/";

                            $name=$p_image->getClientOriginalName();
                            $p_image->move('uploads/nutrition/', $name);

                            $path= "uploads/nutrition/".$name;
                           }








                            NutritionWeekInfo::create([
                                "nutrition_week_id"=>$weeks['id'],
                                'heading'=>$heading,
                                'suggestion'=>$request['suggestions'.str_replace(" ","_",$key)][$key1],
                                'nutrition_advice'=>$description,
                                'image'=>$path,
                            ]);


                        }
                    }


          }
        }



      return redirect()->back()->with('message','Nutrition Program Info has been added');
    }

    public function statusChange(Request $request)
    {
        Nutrition::find($request['id'])->update([
            "status"=>$request['status']
        ]);


        return true;
    }
}
