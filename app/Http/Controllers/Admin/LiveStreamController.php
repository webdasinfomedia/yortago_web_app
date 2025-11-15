<?php

namespace App\Http\Controllers\Admin;

use App\Events\StreamAnswer;
use App\Events\StreamOffer;
use App\Http\Controllers\Controller;
use App\Models\LiveStream;
use App\Models\StreamSession;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use stdClass;

class LiveStreamController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {

        $lists=LiveStream::orderBy('id','desc')->get();


        return view('admin.liveStream.list',get_defined_vars());
    }

    public function save(Request $request)
    {
        // return $request;

        foreach ($request['times'] as $key => $value) {

            $liveStream=LiveStream::find($key);
            $liveStream->streaming_time=$request['times'][$key];
            $liveStream->end_streaming_time=$request['end_streaming_time'][$key];

            if(isset($request['is_active'][$key])){

                $liveStream->is_active=1;
            }else{
                $liveStream->is_active=0;
            }

            $liveStream->update();
        }
           $setting = $request->only('meeting_link');
        foreach ($setting as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $set = Setting::where('key', $key)->first() ?: new Setting();
            $set->key = $key;
            $set->value = $value;
            $set->save();


        }
        return redirect()->back()->with('message','Live Stream Info has been Updated');
    }

    public function stream()
    {


        $session_live=StreamSession::whereDate('start_date',Carbon::now())->where('is_live',0)->get();

        $todayDay= date ('l');
        $array=[];
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

                // return $carbon = new Carbon('YYYY-MM-DD HH:II:SS', 'America/Los_Angeles');


                if ((strtotime($list['streaming_time']) - time())>0 ) {

                    $todayList=new stdClass();
                    $todayList=$list;
                    $todayList=$list;
                    $todayList->streaming_date=Carbon::parse($list['streaming_day']." ".$list['streaming_time'])->format('Y-m-d H:i:s');
                    $todayList->show_counter=true;
                    break;

                 }

                 if(((strtotime($list['end_streaming_time']))-time())>0 && count($session_live)===0){
                    // return 2;
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


        $type="broadcaster";
        $id = Auth::id();

        $streamSession=StreamSession::where('is_live',true)->get();

        // return $todayList;

        if(isset($todayList)){
            $datetime1 = new DateTime($todayList->streaming_date);
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



   $session = StreamSession::whereDate('start_date', Carbon::now())->where('is_live', 0)->get();

       return view('admin.liveStream.stream',get_defined_vars());
    }


    public function startSession(Request $request)
    {
        $session = StreamSession::whereDate('start_date', Carbon::now())->get();

        if (count($session) == 0) {
            StreamSession::create([
                'auth_id' => auth()->user()->id,
                'start_date' => Carbon::now(),
                'is_live' => true,
                'uuid' => uniqid(),
            ]);
        }
         $details = [
                'subject' => 'Meeting Link',
            ];

            $job = (new \App\Jobs\SendQueueEmail($details))
                ->delay(now()->addSeconds(2));

            dispatch($job);
    //   $users=  User::where('user_type',"Stream")->get();

    //   foreach ($users as $key => $user) {
    //     Mail::send('mail.email', get_defined_vars(), function ($send) use ($user) {
    //             $send->to($user['email'])->subject("Meeting Link");

    //         });

    //   }



        return response()->json('welcome user with id ' . Auth::Id());
    }
    public function endSession(Request $request)
    {
        StreamSession::where('auth_id',auth()->user()->id)->where('is_live',true)->update([
            'is_live'=>false,
            'end_date'=>Carbon::now(),
        ]);
        return response()->json(['success'=>true,'user_name'=>auth()->user()->username]);
    }

    public function makeStreamOffer(Request $request)
    {
        $data['broadcaster'] = $request->broadcaster;
        $data['receiver'] = $request->receiver;
        $data['offer'] = $request->offer;

        event(new StreamOffer($data));
    }

    public function makeStreamAnswer(Request $request)
    {
        $data['broadcaster'] = $request->broadcaster;
        $data['answer'] = $request->answer;
        event(new StreamAnswer($data));
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
}