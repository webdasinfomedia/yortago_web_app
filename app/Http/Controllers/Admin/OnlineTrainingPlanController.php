<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineTrainingPlan;
use App\Models\OnlineTrainingPlanAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OnlineTrainingPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index()
    {
        $lists = OnlineTrainingPlan::orderBy('id', 'desc')->get();
        return view('admin.online_training_plan.list', get_defined_vars());
    }

    public function create(Request $request)
    {

        return view('admin.online_training_plan.add');
    }

    public function save(Request $request)
    {
        //    return $request;
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',

        ]);

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $product = $stripe->products->create([
            'name' => $request['name'],
        ]);

        $price = $stripe->prices->create([
            'unit_amount' => $request['price'],
            'currency' => 'usd',
            'recurring' => ['interval' => $request['duration']],
            'product' => $product->id,
        ]);

        $plan = OnlineTrainingPlan::create([
            'name' => $request->name,
            'price' => $request->price,
            'duration' => $request->duration,
            'product_id' => $product->id,
            'price_id' => $price->id,
        ]);

        if (isset($request['attribute_name'])) {

            foreach ($request['attribute_name'] as $key => $value) {

                OnlineTrainingPlanAttribute::create([
                    "online_training_id" => $plan['id'],
                    "name" => $value,
                    "value" => $request['value'][$key],
                ]);
            }
        }

        return redirect('/admin/online/training/plan/list')->with('message', 'Online Training Plan has been added');
    }
    public function update(Request $request)
    {
        //    return $request;
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'duration' => 'required',

        ]);

        $plan = OnlineTrainingPlan::find($request['id']);
        
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $product = $stripe->products->update(
            $plan['product_id'],
            [
                'name' => $request['name'],
            ]
        );

        if ($request['price'] !== $plan['price'] || $request['duration'] !== $plan['duration']) {
            $price = $stripe->prices->create([
                'unit_amount' => $request['price'] * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => $request['duration']],
                'product' => $product->id,
            ]);

            $plan->update([
                'name' => $request->name,
                'price' => $request->price,
                'duration' => $request->duration,
                'product_id' => $product->id,
                'price_id' => $price->id,
            ]);
        } else {
            $plan->update([
                'name' => $request->name,
                'price' => $request->price,
                'duration' => $request->duration,
                'product_id' => $product->id,
            ]);
        }

        OnlineTrainingPlanAttribute::where('online_training_id', $plan['id'])->delete();

        if (isset($request['attribute_name'])) {

            foreach ($request['attribute_name'] as $key => $value) {

                OnlineTrainingPlanAttribute::create([
                    "online_training_id" => $plan['id'],
                    "name" => $value,
                    "value" => $request['value'][$key],
                ]);
            }
        }

        Session::flash('message', 'Stream Rating Has Updated Successfully');

        return redirect()->route('admin.online.training.plan.list');
    }


    public function edit($id)
    {

        $item = OnlineTrainingPlan::with('attributes')->find($id);

        return view('admin.online_training_plan.edit', get_defined_vars());
    }

}
