<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MetricParameter;
use App\Models\Metric;
use App\Models\UserEvaluation;

class UserEvaluationController extends Controller
{
    public function index($userId){

        $user = User::findOrFail($userId);
        return view('admin.userEvaluation.index',get_defined_vars());
    }

    public function userProfile($userId){
        $user = User::where('id', $userId)->select('id','name','email','profile_pic','dob')->first();

        return view('admin.userEvaluation.userProfile',['user' => $user]);
    }

    public function historyView($userId){
        $metric = Metric::select('id','name')->get();
        return view('admin.userEvaluation.previousEvaluation',['metric' => $metric]);
    }

    public function history($userId,$metricId){

        // $data = UserEvaluation::where(['metric_id' => $metricId, 'user_id' => $userId])
        // ->select(
        //     'metric_parameter_id',
        //     \DB::raw('SUM(trial_1 IS NOT NULL) as trial_1_count'),
        //     \DB::raw('SUM(trial_2 IS NOT NULL) as trial_2_count'),
        //     \DB::raw('SUM(trial_3 IS NOT NULL) as trial_3_count'),
        //     \DB::raw('(SUM(trial_1 IS NOT NULL) + SUM(trial_2 IS NOT NULL) + SUM(trial_3 IS NOT NULL)) / 3 as avg_trials_count')
        // )
        // ->with('parameter') // Ensure this relationship is correctly defined
        // ->groupBy('metric_parameter_id')
        // ->get();

        $data = UserEvaluation::where(['metric_id' => $metricId, 'user_id' => $userId])
        ->select(
            'metric_parameter_id', 
            'trial_1', 
            'trial_2', 
            'trial_3',
            // \DB::raw('SUM(trial_1) as trial_1_count'),
            // \DB::raw('SUM(trial_2) as trial_2_count'),
            // \DB::raw('SUM(trial_3) as trial_3_count'),
            \DB::raw('((trial_1) + (trial_2) + (trial_3)) / 3 as avg_trials_count')
        )
        ->with('parameter') // Ensure this relationship is correctly defined
        // ->groupBy('metric_parameter_id')
        ->orderBy('created_at', 'desc')
        ->get();


        // dd($data);
        return response()->json($data);
        // return view('admin.userEvaluation.previousEvaluation',['metric' => $data]);
    }

    public function create(Request $request){

        $metrics = Metric::select('id','name')->get();
        // return view('admin.userEvaluation.create',get_defined_vars());
        return view('admin.userEvaluation.create', ['metrics' => $metrics]);
    }

   public function save(Request $request){
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'metric_id' => 'required|exists:metrics,id',
            'parameters' => 'required|array',
        ]);
    
        try {
            foreach ($request['parameters'] as $item) {
                $userEvaluation = new UserEvaluation();
                $userEvaluation->user_id = $request['user_id'];
                $userEvaluation->metric_id = $request['metric_id'];
                $userEvaluation->metric_parameter_id = $item['parameter_id'] ?? null;
                $userEvaluation->trial_1 = $item['trial_1'] ?? null;
                $userEvaluation->trial_2 = $item['trial_2'] ?? null;
                $userEvaluation->trial_3 = $item['trial_3'] ?? null;
                $userEvaluation->save();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'User Evaluation has been saved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving evaluation: ' . $e->getMessage()
            ], 500);
        }
    }
}
