<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ExerciseProgram;
use App\Models\OnlineTrainingPlan;
use App\Models\StreamPlan;
use App\Models\StreamPlanPurchasedHistory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExerciseProgram;
use App\Models\UserExerciseProgramDay;
use App\Models\UserExerciseProgramWeek;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {


        $streamPlans=StreamPlan::orderBy('total_session','asc')->get();
        $value=json_decode(session('requestValue'));
        $price=0;
        if($value!=null){
            $training_plan=OnlineTrainingPlan::where('price_id',$value->plan_id)->first();
            $price = $training_plan->price;
        }
       
        return view('auth.register',get_defined_vars());
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {


        $rules = array(
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        );
        $validator = Validator::make($request->toArray(), $rules);


        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->errors()->first()

            ), 400); // 400 being the HTTP code for an invalid request.
        }
        $value=json_decode(session('requestValue'));

        try{
            DB::beginTransaction();
            if($value==null){
                $streamPlan=StreamPlan::find($request['stream_id']);

                if($request['stripe_token']!=null){

                    $stripe = new \Stripe\StripeClient(
                        env('STRIPE_SECRET')
                    );
                    $payment=   $stripe->charges->create([
                        'amount' => ($streamPlan->price)*100,
                        'currency' => 'usd',
                        'source' => $request->stripe_token,
                        'metadata' => [
                            'stream_id' => $request->stream_id,
                        ],
                    ]);
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone_no' => $request->phone_no,
                        'joining_purpose' => $request->joining_purpose,
                        'find_us' => $request->find_us,
                        'stream_id' => $streamPlan->id,
                        'no_of_session' => $streamPlan->total_session,
                        'free_session' => $streamPlan->free_session,
                        'payment_key' => $payment->id,
                        'password' => Hash::make($request->password),
                        'time_zone' => $request->timezone,
                    ]);
                    $transaction = Transaction::create([
                        'user_id' => $user->id,
                        'payment_method' => 'stripe',
                        'payment_id' => $payment->id,
                        'stream_id' => $streamPlan->id,
                        'amount' => $streamPlan->price,

                    ]);
                    $start_date=Carbon::now();
                    $end_date=Carbon::now()->addDay($streamPlan->days);
                    StreamPlanPurchasedHistory::create([
                        'user_id'=>$user->id,
                        'stream_plan_id'=>$streamPlan->id,
                        'start_date'=>$start_date,
                        'end_date'=>$end_date,
                    ]);
                }else{
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone_no' => $request->phone_no,
                        'joining_purpose' => $request->joining_purpose,
                        'find_us' => $request->find_us,
                        'stream_id' => $streamPlan->id,
                        'no_of_session' => 0,
                        'free_session' => $streamPlan->free_session,
                        'payment_key' => "#",
                        'password' => Hash::make($request->password),
                        'time_zone' => $request->timezone,
                    ]);
                }
            }else{
                
                $plan = OnlineTrainingPlan::where('price_id',$value->plan_id)->first();
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_no' => $request->phone_no,
                    'joining_purpose' => $request->joining_purpose,
                    'find_us' => $request->find_us,
                    'stream_id' => 0,
                    'no_of_session' => 0,
                    'payment_key' => 0,
                    'age_id' => $value->age_id,
                    'gender_id' => $value->gender_id,
                    'equipment_id' => @$value->equipment_id,
                    'experience_level_id' =>@$value->experience_id,
                    'user_type' =>"OnlineTraining",
                    'password' => Hash::make($request->password),
                    'online_training_plan_id' => $plan->id
                ]);

                if($plan->duration == 'life-time')
                {
                    $stripe = new \Stripe\StripeClient(
                        env('STRIPE_SECRET')
                    );
                    $payment = $stripe->charges->create([
                        'amount' => ($plan->price)*100,
                        'currency' => 'usd',
                        'source' => $request->stripe_token,
                        'metadata' => [
                            'online_training_plan_id' => $plan->id,
                        ],
                    ]);
                }
                else
                {
                    $payment = $user->newSubscription('Subscription',$value->plan_id)
                    ->create($request->stripe_token, [
                        'email' => $user->email,
                    ]);
                }
                Transaction::create([
                    'user_id' => $user->id,
                    'payment_method' => 'stripe',
                    'payment_id' => $payment->id,
                    'stream_id' => 0,
                    'amount' => $plan->price,
                ]);

                // Assign User Exercise Program

                $exercise_program=ExerciseProgram::with('exercise_weeks.exercise_days.exercise_infos')->where('gender_id',$value->gender_id)->where('age_id',$value->age_id)
                    ->where('experience_level_id',$value->experience_id)->where('equipment_id',$value->equipment_id)->where('status',1)->first();

                if(isset($exercise_program)){
                    // return  $exercise_program;
                    foreach ($exercise_program['exercise_weeks'] as $key => $week) {

                        $weekSave=UserExerciseProgramWeek::create([
                            "week_name"=>$week['week_name'],
                            "user_id"=>$user['id']
                        ]);

                        foreach ($week['exercise_days'] as $key => $exercise_days) {
                            $savedDay=UserExerciseProgramDay::create([
                                "day_name"=>$exercise_days['day_name'],
                                "user_exercise_program_week_id"=>$weekSave['id'],
                                "user_id"=>$user['id']
                            ]);

                            foreach ($exercise_days['exercise_infos'] as $key => $exercise_infos) {
                                UserExerciseProgram::create([
                                    'user_id'=>$user['id'],
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
                }
            }
            
            event(new Registered($user));
            Mail::send([], [], function ($message) use($user) {
                $message->to('info@yortago.com')
                ->subject('New user registered')
                ->setBody('<h1>Hi,</h1><p>A new user <b>('.$user->name.')</b> registered for <b>'.($user->online_training_plan_id ? 'Online Training' : 'Live Stream').'</b>. Goto dashboard for more details</p>', 'text/html');
            });
            
            session(['requestValue' => null]);
            DB::commit();
            Auth::login($user);

            return Response::json(array(
                'success' => true,
                'errors' => "Register Successfully"
            ));

        }catch(\Exception $e){
           DB::rollBack();
           dd($e->getMessage());
            return Response::json(array(
                'success' => false,
                'errors' => "something went wrong"

            ));
        }




    }
}
