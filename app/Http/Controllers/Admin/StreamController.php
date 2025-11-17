<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use App\Http\Traits\ExerciseTrait;

use App\Models\NewUserExerciseLog;

use App\Models\LiveStream;

use App\Models\StreamPlan;

use App\Models\User;

use App\Models\ExerciseNote;

use Carbon\Carbon;

use DateTime;



use Stripe\Checkout\Session as StripeSession;

use Illuminate\Support\Facades\Log;

use Stripe\Stripe;



use Stripe\Product;

use Stripe\Price;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use stdClass;



use Illuminate\Support\Str;





class StreamController extends Controller

{

    use ExerciseTrait;

    public function __construct()

    {

        $this->middleware('is_admin');

    }



    public  function index()

    {

        $lists=StreamPlan::orderBy('total_session','asc')->get();

       return view('admin.streamPlan.list',get_defined_vars());

    }

    public  function create()

    {

       return view('admin.streamPlan.add');

    }



    public function save(Request $request)

    {



        $request->validate([

            'name'=>'required',

            'price'=>'required',

            'days'=>'required|numeric',

            'plan_description'=>'required',

            'total_session'=>'required',



        ]);







        StreamPlan::create([

            'name'=>$request->name,

            'price' => $request->price,

            'days' => $request->days,

            'plan_description' => $request->plan_description,

            'total_session' => $request->total_session,

            'free_session' => $request->free_session,

        ]);



        Session::flash('message','Stream Plan has been added');



        return redirect()->route('admin.streaming.list');

    }



    public function update(Request $request)

    {



        $request->validate([

            'name'=>'required',

            'price'=>'required',

            'days'=>'required|numeric',

            'plan_description'=>'required',

            'total_session'=>'required',



        ]);



        StreamPlan::find($request['id'])->update([

            'name'=>$request->name,

            'price' => $request->price,

            'days' => $request->days,

            'plan_description' => $request->plan_description,

            'total_session' => $request->total_session,

            'free_session' => $request->free_session,



        ]);









        Session::flash('message','Stream Plan has been Updated');



        return redirect()->route('admin.streaming.list');

    }





    public function edit($id)

    {



        $list=StreamPlan::find($id);





        return view('admin.streamPlan.edit',get_defined_vars());

    }



    public function delete($id)

    {

        StreamPlan::where('id',$id)->delete();

        return redirect()->back()->with('message','Stream Plan has been deleted');

    }













    public static function hourLeft()

    {

        $date="2011-09-23 19:10:18";//Your date

        $date=strtotime($date);//Converted to a PHP date (a second count)



        //Calculate difference

        $diff=$date-time();//time returns current time in seconds

        $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)

       return $hours=round(($diff-$days*60*60*24)/(60*60));

    }

    // public function UsersList(){

    //     $test_types = $this->test_types();

    //     $lists=User::where('user_type','OnlineTraining')->orderBy('id','desc')->get();



    //     return view('admin.users.live-stream-index',get_defined_vars());

    // }



    // public function UsersList(){

    //     $test_types = $this->test_types();

    //     $lists=User::where('user_type','OnlineTraining')->orderBy('id','desc')->get();



    //     return view('admin.users.live-stream-index',get_defined_vars());

    // }

//     public function UsersList()

// {

//     // Load users with their subscriptions eager loaded

//     $lists = User::with('subscription')

//                 ->where('user_type', 'OnlineTraining')

//                 ->orderBy('id', 'desc')

//                 ->get();



//     // Prepare a simpler array for JavaScript usage

//     $users = $lists->map(function ($user) {

//         return [

//             'id' => $user->id,

//             'name' => $user->name,

//             'subscription_link' => $user->subscription_link ?? null,

//             'is_subscribed' => $user->is_subscribed,

//             // Use user's stripe_status if set, otherwise fallback to subscription's stripe_status if subscription exists

//             'stripe_status' => $user->stripe_status ?? ($user->subscription->stripe_status ?? null),

//         ];

//     });



//     // Pass both the original users collection and mapped array to the view

//     return view('admin.users.live-stream-index', compact('lists', 'users'));

// }



public function UsersList()

{

    // Load users with their subscriptions and exercise logs eager loaded

    $lists = User::with(['subscription', 'exerciseLogs' => function($query) {

                    $query->orderBy('created_at', 'desc');

                }])

                ->where('user_type', 'OnlineTraining')

                ->orderBy('id', 'desc')

                ->get();


    // Prepare a simpler array for JavaScript usage

    $users = $lists->map(function ($user) {

        return [

            'id' => $user->id,

            'name' => $user->name,

            'subscription_link' => $user->subscription_link ?? null,

            'is_subscribed' => $user->is_subscribed,

            'stripe_status' => $user->stripe_status ?? ($user->subscription->stripe_status ?? null),

            'logs_count' => $user->exerciseLogs->count(),

        ];

    });



    return view('admin.users.live-stream-index', compact('lists', 'users'));

}

public function showUserLogs($userId)
{
    $user = User::findOrFail($userId);
    $logs = NewUserExerciseLog::where('user_id', $userId)
            ->with([
                'exerciseItem.exercise_list', // Load exercise item and its exercise list
                'replacedExerciseItem.exercise_list', // Load replaced exercise item
                'newUserExercise.newExercise', // Load user exercise program and exercise
                'bodyPart'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
   
    // Fetch exercise notes for this user
    $exerciseNotes = ExerciseNote::where('user_id', $userId)
            ->with(['exerciseItem', 'userExercise'])
            ->get()
            ->groupBy('new_item_id'); // Group by item_id for easy lookup
    
    return view('admin.users.user-logs', compact('user', 'logs','exerciseNotes'));
}

public function getUserLogs(User $user)

{

    $logs = NewUserExerciseLog::where('user_id', $user->id)

        ->with([

            'userExerciseProgram:id,new_exercise_id,user_id,start_date,completion_date',

            'userExerciseProgram.exercise:id,title',

            'exerciseItem:id,name',

            'replacedExerciseItem:id,name',

            'bodyPart:id,name'

        ])

        ->orderBy('created_at', 'desc')

        ->get()

        ->map(function ($log) {

            return [

                'id' => $log->id,

                'created_at' => $log->created_at,

                'updated_at' => $log->updated_at,

                'sets' => $log->sets,

                'reps' => $log->reps,

                'weight' => $log->weight,

                'weight_unit' => $log->weight_unit,

                'notes' => $log->notes,

                'intensity' => $log->intensity,

                'time_taken' => $log->time_taken,

                'exercise_name' => optional($log->userExerciseProgram)->exercise->title ?? 'N/A',

                'exercise_item' => optional($log->exerciseItem)->name ?? 'N/A',

                'replaced_exercise_item' => optional($log->replacedExerciseItem)->name ?? 'N/A',

                'body_part' => optional($log->bodyPart)->name ?? 'N/A',

                'program_start_date' => optional($log->userExerciseProgram)->start_date,

                'program_completion_date' => optional($log->userExerciseProgram)->completion_date

            ];

        });

        

    return response()->json($logs);

}





public function storeUserLog(Request $request)

{

    $request->validate([

        'user_id' => 'required|exists:users,id',

        'new_user_exercise_id' => 'required|exists:new_user_exercises,id',

        'sets' => 'required',

        'reps' => 'required',

        'weight' => 'required',

    ]);



    $log = NewUserExerciseLog::create([

        'user_id' => $request->user_id,

        'new_user_exercise_id' => $request->new_user_exercise_id,

        'sets' => json_encode([$request->sets]),

        'reps' => json_encode([$request->reps]),

        'weight' => json_encode([$request->weight]),

        'notes' => $request->notes,

    ]);



    return response()->json(['message' => 'Log created successfully', 'log' => $log]);

}

    public function createSubscription(Request $request)

{

    $validated = $request->validate([

        'user_id' => 'required|exists:users,id',

        'amount' => 'required|numeric|min:1',

        'name' => 'required|string',

        'interval' => 'required|in:week,month,year',

    ]);



    try {

        $user = User::findOrFail($validated['user_id']);

        Stripe::setApiKey(env('STRIPE_SECRET'));



        // 1. Create product

        $product = \Stripe\Product::create([

            'name' => $validated['name'],

        ]);



        // 2. Create price

        $price = \Stripe\Price::create([

            'unit_amount' => $validated['amount'] * 100,

            'currency' => 'usd',

            'recurring' => ['interval' => $validated['interval']],

            'product' => $product->id,

        ]);



        // 3. Create checkout session

        $checkoutSession = StripeSession::create([

            'payment_method_types' => ['card'],

            'line_items' => [[

                'price' => $price->id,

                'quantity' => 1,

            ]],

            'mode' => 'subscription',

            'customer_email' => $user->email,

            'success_url' => route('admin.subscriptions.markSubscribed', $user->id) . '?session_id={CHECKOUT_SESSION_ID}',

            'cancel_url' => url()->previous(),

        ]);



        // 4. Update user only AFTER $checkoutSession exists

        $user->update([

            'subscription_name' => $validated['name'],

            'subscription_interval' => $validated['interval'],

            

            'stripe_status' => 'pending',

            'stripe_token' => $request->_token, // or generate a secure token

            'subscription_link' => $checkoutSession->url,

        'stripe_temp_session_id' => $checkoutSession->id,

            'subscription_amount' => $validated['amount'],

        ]);



        return response()->json([

           

           'link' => $checkoutSession->url,

            'message' => 'Payment link generated successfully',

            'user_email' => $user->email,

        ]);

    } catch (\Exception $e) {

        \Log::error('Stripe Subscription Error: ' . $e->getMessage());

        return response()->json([

            'error' => true,

            'message' => 'Failed to generate payment link',

            

            'details' => $e->getMessage(),

        ], 500);

    }

}

    public function markAsSubscribed(User $user, Request $request)

{

    $sessionId = $request->get('session_id');



    if (!$sessionId) {

        return redirect()->route('home')->with('error', 'Missing session ID.');

    }



    Stripe::setApiKey(env('STRIPE_SECRET'));

    $session = \Stripe\Checkout\Session::retrieve($sessionId);



    if ($session && $session->payment_status === 'paid') {

        $user->update([

            'stripe_status' => 'active',

            'is_subscribed' => true,

        ]);

        return redirect()->route('home')->with('success', 'Subscription successful!');

    }



    return redirect()->route('home')->with('error', 'Subscription not completed.');

}



public function pauseSubscription(Request $request, User $user)

    {

        try {

            if ($user->stripe_status !== 'active') {

                return back()->with('error', 'Subscription is not active.');

            }



            // Just update local status

            $user->update([

                'stripe_status' => 'paused',

                'is_subscribed' => false,

            ]);



            return back()->with('success', 'Subscription paused successfully.');

        } catch (\Exception $e) {

            \Log::error('Pause subscription error: ' . $e->getMessage());

            return back()->with('error', 'Failed to pause subscription.');

        }

    }



    public function cancelSubscription(Request $request, User $user)

    {

        try {

            if (!in_array($user->stripe_status, ['active', 'paused'])) {

                return back()->with('error', 'No active or paused subscription found.');

            }



            // Just update local status

            $user->update([

                'stripe_status' => 'canceled',

                'is_subscribed' => false,

            ]);



            return back()->with('success', 'Subscription canceled successfully.');

        } catch (\Exception $e) {

            \Log::error('Cancel subscription error: ' . $e->getMessage());

            return back()->with('error', 'Failed to cancel subscription.');

        }

    }

public function resumeSubscription(Request $request, User $user)

{

    try {

        if ($user->stripe_status !== 'paused') {

            return back()->with('error', 'Subscription is not paused.');

        }



        // Just update local status

        $user->update([

            'stripe_status' => 'active',

            'is_subscribed' => true,

        ]);



        return back()->with('success', 'Subscription resumed successfully.');

    } catch (\Exception $e) {

        \Log::error('Resume subscription error: ' . $e->getMessage());

        return back()->with('error', 'Failed to resume subscription.');

    }

}



}