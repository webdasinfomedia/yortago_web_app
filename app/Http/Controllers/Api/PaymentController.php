<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\StreamPlan;
use Laravel\Cashier\Subscription;
use App\Models\Transaction;
use App\Models\StreamPlanPurchasedHistory;
use App\Models\OnlineTrainingPlan;
use Carbon\Carbon;



class PaymentController extends Controller
{
    use ResponseTrait; 
    public function payoutSubmit(Request $request)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'stream_id' => 'nullable|integer',
                'payment_method' => 'required|string',
                'price_id' => 'nullable',
            ]);
            if ($validator->fails()) {
                return $this->returnApiResponse(422, "Validation error", array('error' => $validator->errors()));
            }
    
            $user = auth()->user();
            // return $user;
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            
            // if ($user->user_type == 'Stream') {
            //     $streamPlan = StreamPlan::findOrFail($request->stream_id);
                
            //     $payment = $stripe->charges->create([
            //         'amount' => $streamPlan->price * 100,
            //         'currency' => 'usd',
            //         'source' => $request->payment_method,
            //         'metadata' => [
            //             'stream_id' => $streamPlan->id,
            //         ],
            //     ]);
            //     $user->update([
            //         'stream_id' => $streamPlan->id,
            //         'no_of_session' => $streamPlan->total_session,
            //     ]);
            //     Transaction::create([
            //         'user_id' => $user->id,
            //         'payment_method' => 'stripe',
            //         'payment_id' => $payment->id,
            //         'stream_id' => $streamPlan->id,
            //         'amount' => $streamPlan->price,
            //     ]);
            //     StreamPlanPurchasedHistory::create([
            //         'user_id' => $user->id,
            //         'stream_plan_id' => $streamPlan->id,
            //         'start_date' => Carbon::now(),
            //         'end_date' => Carbon::now()->addDays($streamPlan->days),
            //     ]);
            // } else
            if ($user->user_type == 'OnlineTraining') {
                $plan = OnlineTrainingPlan::where('price_id', $request->price_id)->firstOrFail();
                
                // Create a subscription
                $subscription = $user->newSubscription('Subscription', $request->price_id)
                    ->create($request->payment_method, [
                        'email' => $user->email,
                    ]);
    
                Transaction::create([
                    'user_id' => $user->id,
                    'payment_method' => 'stripe',
                    'payment_id' => $subscription->stripe_id,
                    'stream_id' => 0,
                    'amount' => $plan->price,
                ]); 
            }
    
            return $this->returnApiResponse(200, 'Subscription has been done successfully', []);
        } catch (\Exception $e) {
            return $this->returnApiResponse(400, $e->getMessage(), array('error' => $e));
        }
    }


    public function handleWebhook(Request $request)
    {
        $stripePayload = $request->all();
        Log::notice("Webhook received", $stripePayload);

        $eventData = $stripePayload['data']['object'] ?? null;
        if ($eventData) {
            $customerId = $eventData['customer'] ?? null;
            $amount = $eventData['items']['data'][0]['plan']['amount'] ?? 0;

            $user = User::where('stripe_id', $customerId)->first();
            if ($user) {
                Transaction::create([
                    'user_id' => $user->id,
                    'payment_method' => 'stripe', 
                    'payment_id' => $eventData['id'],
                    'stream_id' => 0,
                    'amount' => $amount / 100,
                ]);
            }
        }

        return response()->json(['message' => 'Webhook handled successfully'], 200);
    }


    public function subscriptionFailed(Request $request)
	{
		$customer_id=$request['data']['object']['customer'];
		$description=$request['data']['object']['description'];

        if($description=='Subscription creation')
		{
			$user = User::where('stripe_id', $customer_id)->first();
            if ($user) {
                User::where('stripe_id', $customer_id)->update(['is_subscribed' => false]);
                Subscription::where('user_id', $user->id)->delete();
                return response()->json(['status'=>200]);
            } 
		}


	}


    
}
