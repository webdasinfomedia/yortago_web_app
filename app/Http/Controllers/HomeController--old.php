<?php

namespace App\Http\Controllers;

use App\Events\StreamAnswer;
use App\Models\Age;
use App\Models\Contact;
use App\Models\Equipment;
use App\Models\ExperienceLevel;
use App\Models\Gender;
use App\Models\LiveStream;
use App\Models\NewsLetter;
use App\Models\Nutrition;
use App\Models\OnlineTrainingPlan;
use App\Models\Slider;
use App\Models\StreamPlan;
use App\Models\StreamPlanPurchasedHistory;
use App\Models\StreamRating;
use App\Models\StreamSession;
use App\Models\OfferedStream;
use App\Models\Testimonial;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserExerciseProgram;
use App\Models\UserStreamSession;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Cashier\Subscription;
use App\Models\UserExerciseProgramDay;
use App\Models\UserExerciseProgramWeek;
use stdClass;
use Stripe\Stripe;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_user')->except('aboutUs','home','onlineTraining','onlineTrainingSave','inPerson','saveContact','saveNewsLetter','signUpPage','onlineTrainingView','liveStreamView','termCondition','privacyPolicy','handleWebhook','subscriptionFailed');
    }



    public function home(){

        session(['requestValue' => null]);
        $sliders=Slider::orderBy('id','desc')->get();
        $testimonials=Testimonial::orderBy('id','desc')->get();

        return view('front.home',get_defined_vars());
    }
    public function aboutUs(){

        session(['requestValue' => null]);
            

        return view('front.about',get_defined_vars());
    }
    public function termCondition(){

        session(['requestValue' => null]);


        return view('front.term',get_defined_vars());
    }
    public function privacyPolicy(){

        session(['requestValue' => null]);


        return view('front.privacy',get_defined_vars());
    }

    public function dashboard()
    {
        $total_session=UserStreamSession::where('user_id',auth()->user()->id)->count();


        // Chart

        $now = Carbon::now();
        $first_day_this_week = $now->startOfWeek()->format('Y-m-d H:i');
        $last_day_this_week  = $now->endOfWeek()->format('Y-m-d H:i');

        $first_day_this_month = $now->startOfMonth()->format('Y-m-d H:i');
        $last_day  = Carbon::now()->format('Y-m-d H:i');

        $streamRating= StreamRating::where('user_id',auth()->user()->id)->whereBetween('created_at', [Carbon::parse($first_day_this_week)->format('Y-m-d')." 00:00:00", Carbon::parse($last_day_this_week)->format('Y-m-d')." 23:59:59"])->get();
        $streamRatingMonth= StreamRating::where('user_id',auth()->user()->id)->whereBetween('created_at', [Carbon::parse($first_day_this_month)->format('Y-m-d')." 00:00:00", Carbon::parse($last_day)->format('Y-m-d')." 23:59:59"])->get();

        $periods = CarbonPeriod::create($first_day_this_week,$last_day_this_week);
        $period_months = CarbonPeriod::create($first_day_this_month,$last_day);

        $labelArray=[];
        $dataArray=[];

        foreach ($periods as $key => $period) {
            $founds = array_filter($streamRating->toArray(), function ($item) use ($period) {
                return (Carbon::parse($item['created_at'])->format('Y-m-d')===Carbon::parse($period)->format('Y-m-d'));
            });

            if(count($founds)==0){

                array_push($labelArray,Carbon::parse($period)->format('l'));
                array_push($dataArray,0);

            }else{
                array_push($dataArray,$founds[0]['rating']);
                array_push($labelArray,Carbon::parse($period)->format('l'));
            }
        }
        $labelMonthArray=[];
        $dataMonthArray=[];

        foreach ($period_months as $key => $period) {
            $founds = array_filter($streamRatingMonth->toArray(), function ($item) use ($period) {
                return (Carbon::parse($item['created_at'])->format('Y-m-d')===Carbon::parse($period)->format('Y-m-d'));
            });

            if(count($founds)==0){

                array_push($labelMonthArray,Carbon::parse($period)->format('d M'));
                array_push($dataMonthArray,0);

            }else{
                foreach($founds as $found){
                    array_push($dataMonthArray,$found['rating']);
                }

                array_push($labelMonthArray,Carbon::parse($period)->format('d M'));
            }
        }

        // return $labelMonthArray;


        // Exercise Program

        $exercise_programs=UserExerciseProgram::where('user_id',auth()->user()->id)->limit(6)->get();

        if(auth()->user()->user_type=="Stream"){

            return view('front.dashboard.pages.dashboard',get_defined_vars());
        }
        else{

            return redirect()->route('online.training.all');
        }


    }

    public function liveStream()
    {


        if(auth()->user()->free_session==0){


        if( auth()->user()->no_of_session==0 || !auth()->user()->PlanValidate()){

            $streamPlan=StreamPlan::find(auth()->user()->stream_id);
            Session::flash('error','Pay Your dues to Continue Your Live Stream Session');
            return view('front.dashboard.payout',get_defined_vars());
        }
        }

        // $session_live=StreamSession::whereDate('start_date',Carbon::now())->where('is_live',false)->get();

         $streamRatings=StreamRating::whereDate('date',Carbon::now())->where('user_id',auth()->user()->id)->get();


        $todayDay= date ('l');
        if($todayDay=="Monday"){
            $array=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        }
        else if($todayDay=="Tuesday"){
            $array=['Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday','Monday'];
        }
        else if($todayDay=="Wednesday"){
            $array=['Wednesday','Thursday','Friday','Saturday','Sunday','Monday','Tuesday'];
        }
        else if($todayDay=="Thursday"){

            $array=['Thursday','Friday','Saturday','Sunday','Monday','Tuesday','Wednesday'];
        }
        else if($todayDay=="Friday"){
            $array=['Friday','Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday'];
        }
        else if($todayDay=="Saturday"){
            $array=['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
        }
        else if($todayDay=="Sunday"){
            $array=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
        }
        $imploded_strings = implode("','", $array);
        $lists=LiveStream::where('is_active',1)->wherein('streaming_day',$array)->orderByRaw(DB::raw("FIELD(streaming_day, '$imploded_strings')"))->get();

        $nextDate=date("Y-m-d", time() + 86400);


        // $todayDay= date ('l');
        $nextDay= date ('l',strtotime($nextDate));

        $todayList="";

        foreach ($lists as $key => $list) {

            if($list['streaming_day']==$todayDay){

                $date_now = new DateTime();
                $date2    = new DateTime(Carbon::parse($list['streaming_day']." ".$list['streaming_time'])->format('Y-m-d H:i:s'));

            if ((strtotime($list['streaming_time']) - time())>0 ) {

                $todayList=new stdClass();
                $todayList=$list;
                $todayList=$list;
                $todayList->streaming_date=Carbon::parse($list['streaming_day']." ".$list['streaming_time'])->format('Y-m-d H:i:s');
                $todayList->show_counter=true;

                break;


             }

             if(((strtotime($list['end_streaming_time']))-time())> 0  && count($streamRatings)==0  ){

                $todayList=new stdClass();
                $todayList=$list;
                $todayList=$list;
                $todayList->streaming_date=Carbon::parse($list['streaming_day']." ".$list['streaming_time'])->format('Y-m-d H:i:s');
                $todayList->show_counter=false;

                break;

             }
             }

            else{

                    $todayList=new stdClass();
                    $todayList=$list;
                    $todayList->streaming_date=Carbon::parse($list['streaming_day']." ".$list['streaming_time'])->format('Y-m-d H:i:s');
                    $todayList->show_counter=true;

                break;
            }

        }

        $streamId="112acde2";
        $user=User::where('id',$streamId)->first();

        $type="consumer";

        $id = Auth::id();
        $user=$user;

        // return $todayList;

       return view('front.dashboard.pages.stream',get_defined_vars());
    }

    public function makeStreamAnswer(Request $request)
    {

        $data['broadcaster'] = $request->broadcaster;
        $data['answer'] = $request->answer;
        event(new StreamAnswer($data));
    }

    public function getOfferedStream($id)
    {
        $offered_stream = OfferedStream::find($id);
        return $offered_stream->offer_data;
    }

    public function sessionStart(Request $request)
    {
        $session = UserStreamSession::whereDate('start_date', Carbon::now())->where('user_id', auth()->user()->id)->get();
        if (count($session) == 0) {

                UserStreamSession::create([
                    'user_id' => auth()->user()->id,
                    'start_date' => Carbon::now(),
                    'session' => 1,
                    'stream_id' => 'zoom_'.Carbon::today()->format('Y-m-d'),
                ]);
                if (auth()->user()->free_session > 0) {
                    User::find(Auth::user()->id)->update(["free_session" => auth()->user()->free_session - 1]);

                } else {

                    User::find(Auth::user()->id)->update(["no_of_session" => auth()->user()->no_of_session - 1]);
                }
                return response()->json([
                    "status" => true,
                    'message' => "welcome user with id '. Auth::Id()",

                ]);
            }
            return response()->json([
                "status" => true,
                'message' => "welcome user with id '. Auth::Id()",

            ]);
        }

    // streamRating

    public function streamRating()
    {

        $stream=UserStreamSession::whereDate('start_date',Carbon::now())->get();

        if(count($stream)>0){
            $ratings=StreamRating::where('stream_id',$stream[0]['stream_id'])->get();

            if(count($ratings)==0){

                return view('front.dashboard.pages.rating',get_defined_vars());
            }else{
              return redirect()->route('live.stream');

            }

        }else{
            return redirect()->route('live.stream');
        }



    }
    public function streamRatingSubmit($id)
    {


        $stream=UserStreamSession::whereDate('start_date',Carbon::now())->get();

        if(count($stream)>0){
            $ratings=StreamRating::where('stream_id',$stream[0]['stream_id'])->get();

            if(count($ratings)>0){

                return redirect()->route('dashboard');
            }else{
                StreamRating::create([
                    'user_id'=>auth()->user()->id,
                    'date'=>Carbon::now(),
                    'stream_id'=>$stream[0]['stream_id'],
                    'rating'=>$id
                ]);
                Session::flash('message','Stream Rating Has Saved Successfully');
                // return redirect()->back()->with('message','Stream Rating Has Saved Successfully');
                return redirect()->route('dashboard');
            }

        }else{
            return redirect()->route('dashboard');
        }



    }

    public function onlineTraining(Request $request)
    {
        session(['requestValue' => null]);
        $plans=OnlineTrainingPlan::orderBy('id','desc')->get();
        $ages=Age::all();
        $experience_levels=ExperienceLevel::all();
        $genders=Gender::all();
        $equipments=Equipment::all();

        return view('front.online_training',get_defined_vars());
    }

    public function inPerson(Request $request)
    {
        session(['requestValue' => null]);

        return view('front.in_person',get_defined_vars());
    }

    public function onlineTrainingSave(Request $request)
    {

        session(['requestValue' => json_encode($request->all())]);

        return redirect()->route('register');
    }

    public function onlineTrainingAll()
    {


        $exercise_programs=UserExerciseProgram::where('user_id',auth()->user()->id)->first();

        $item=User::with('exercise_weeks.exercise_days.exercise_infos')->find(auth()->user()->id);

        $totalWeek=count($item['exercise_weeks']);
        $date = Carbon::parse($item['created_at']);
        $now = Carbon::now();

        $diff = $date->diffInDays($now);
        $currentWeek=round($diff/7);
        if($currentWeek==0){
            $currentWeek=1;
        }

       $dayName=date ('l');
       if($dayName=="Monday"){
        $dayName="Day ONE";
       }
       elseif($dayName=="Tuesday"){
        $dayName="Day Two";
       }
       elseif($dayName=="Wednesday"){
        $dayName="Day THREE";
       }
       elseif($dayName=="Thursday"){
        $dayName="Day FOUR";
       }
       elseif($dayName=="Friday"){
        $dayName="Day Five";
       }
       elseif($dayName=="Saturday"){
        $dayName="Day Six";
       }
       elseif($dayName=="Sunday"){
        $dayName="Day Seven";
       }





        return view('front.dashboard.pages.online_training',get_defined_vars());
    }
    public function profile()
    {

        $user=Auth::user();


        return view('front.dashboard.pages.profile',get_defined_vars());
    }

    public function updateProfile(Request $request)
    {
    //  return  $request;
      $user = User::find(Auth::User()->id);

        $request->validate([
            'name'=>'required',
            'email'=>'required',
        ]);
        // return 1;
        if ($request->email != $user->email) {
            $request->validate([
                'email' =>'required|email|unique:users',
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->joining_purpose = $request->joining_purpose;

        if($request->hasfile('profile_pic')){
            $image = $request->file('profile_pic');
            $filename = 'uploads/users/'.time() . '.' . $image->getClientOriginalExtension();
            $movedFile = $image->move('uploads/users/', $filename);
            $user->profile_pic = $filename;
            $user->save();
        }else {
            $user->save();
        }
        return redirect()->back()->with('message','Profile has been updated');
    }


     /*****     Password Update      *****/

    public function updatePassword(Request $request)
    {
        // return $request;

        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->back()->with('message','Password has been updated');

    }

    public function nutrition()
    {
       $user=Auth::user();

     $nutrition=  Nutrition::with('nutrition_weeks.nutrition_info')->where('age_id',$user->age_id)->where('gender_id',$user->gender_id)->where('experience_level_id',$user['experience_level_id'])->where('equipment_id',$user['equipment_id'])->first();

       return view('front.dashboard.pages.nutrition',get_defined_vars());
    }

    public function saveContact(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'last_name'=>'required',
            'email'=>'required',
            'mobile_no'=>'required',
            'message'=>'required',


        ]);

        Contact::create([
            'name'=>$request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'message' => $request->message

        ]);

        return redirect()->back()->with('message','Contact Info Saved Successfully');



    }

    public function saveNewsLetter(Request $request)
    {
        $request->validate([

            'email'=>'required',
        ]);

        NewsLetter::create([

            'email' => $request->email,
        ]);

        return redirect()->back()->with('message','NewsLetter Info Saved Successfully');

    }

    public function signUpPage(Request $request)
    {



        return view('front.signup-page');
    }


    public function onlineTrainingView()
    {
        $value=json_decode(session('requestValue'));
        $price=0;
        if($value!=null){
            return redirect()->route('register');
        }
        else{

            return redirect()->route('online.training');
        }


    }


    public function liveStreamView()
    {
        session(['requestValue' => null]);

    //   return  $value=json_decode(session('requestValue'));

        return redirect()->route('register');
    }

    public function getTimeLeft(Request $request)
    {
        if(isset($request)){
            $datetime1 = new DateTime($request->record['streaming_date']);
            $datetime2 = new DateTime();
            $interval = $datetime1->diff($datetime2);
             $data=new stdClass();
             $data->hour=$interval->format('%h');
             $data->mint=$interval->format('%i');
             $data->sec=$interval->format('%s');
             $data->day=$interval->format('%d');
        }else{

             $data=new stdClass();
             $data->hour=0;
             $data->mint=0;
             $data->sec=0;
             $data->day=0;
        }


        return $data;
    }

    public function payout()
    {

        if( auth()->user()->user_type=='Stream' && auth()->user()->no_of_session==0){

            $streamPlan=StreamPlan::find(auth()->user()->stream_id);
            return view('front.dashboard.payout',get_defined_vars());
        }else if( auth()->user()->user_type=='OnlineTraining' && ! auth()->user()->subscribed('Subscription')){

            $onlineTraningPlans=OnlineTrainingPlan::first();
            return view('front.dashboard.payout',get_defined_vars());
        }else{
            return redirect()->route('dashboard');
        }




    }

    public function payoutSubmit(Request $request)
    {


        //dd('sk_test_OPZIufRlS22dhu4r5Phf5rD9');
        $stripe = new \Stripe\StripeClient(
            'sk_test_OPZIufRlS22dhu4r5Phf5rD9'
        );

        if(auth()->user()->user_type=='Stream') {
        $streamPlan = StreamPlan::find($request->stream_id);

            $stripe = new \Stripe\StripeClient(
                'sk_test_OPZIufRlS22dhu4r5Phf5rD9'
            );
        $payment = $stripe->charges->create([
            'amount' => ($streamPlan->price) * 100,
            'currency' => 'usd',
            'source' => $request->stripe_token,
            'metadata' => [
                'stream_id' => $request->stream_id,
            ],
        ]);

        $user = User::find(auth()->user()->id)->update([

            'stream_id' => $streamPlan->id,
            'no_of_session' => $streamPlan->total_session,
        ]);
        $transaction = Transaction::create([
            'user_id' => auth()->user()->id,
            'payment_method' => 'stripe',
            'payment_id' => $payment->id,
            'stream_id' => $streamPlan->id,
            'amount' => $streamPlan->price,

        ]);
        $start_date = Carbon::now();
        $end_date = Carbon::now()->addDay($streamPlan->days);
        StreamPlanPurchasedHistory::create([
            'user_id' => auth()->id(),
            'stream_plan_id' => $streamPlan->id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
        if(auth()->user()->user_type=='OnlineTraining') {
            $user=User::find(auth()->id());
             Stripe::setApiKey('sk_test_OPZIufRlS22dhu4r5Phf5rD9');
            $sub = $user->newSubscription('Subscription', $request->plan_id)
                ->create($request->stripe_token, [
                    'email' => $user->email,
                ]);

            $plan = OnlineTrainingPlan::where('price_id', $request->plan_id)->first();
            $price = 0;
            if (isset($plan)) {
                $price = $plan['price'];
            }

            Transaction::create([
                'user_id' => $user->id,
                'payment_method' => 'stripe',
                'payment_id' => $sub->stripe_id,
                'stream_id' => 0,
                'amount' => $price,

            ]);

        }
        return true;
    }

    public function handleWebhook(Request $request)
    {
         Log::notice("webhook message 1",$request['data']['object']);

         $customer_id = $request['data']['object']['customer'];
         $amount=$request['data']['object']['items']['data'][0]['plan']['amount'];

             $user = User::where('stripe_id',$customer_id)->first();

             if(isset($user)){
                Transaction::create([
                    'user_id' => $user->id,
                    'payment_method' => 'stripe',
                    'payment_id' =>$request['data']['object']['id'],
                    'stream_id' => 0,
                    'amount' => $amount/100,

                ]);
             }



         return response()->json(['status'=>200]);
    }

    public function subscriptionFailed(Request $request)
	{
		$customer_id=$request['data']['object']['customer'];
		$description=$request['data']['object']['description'];
		if($description=='Subscription creation')
		{
			$user = User::where('stripe_id',$customer_id)->first();
			Subscription::where('user_id',$user->id)->delete();
			return response()->json(['status'=>200]);
		}


	}
	    public function completeWeek($id){

        UserExerciseProgramDay::find($id)->update([
            'is_completed'=>1,


        ]);

        return redirect()->back()->with('message','Status Complete Successfully');

    }
}
