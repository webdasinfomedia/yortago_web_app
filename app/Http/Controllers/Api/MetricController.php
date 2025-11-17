<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Metric;
use App\Http\Traits\ResponseTrait;
use App\Models\UserEvaluation;
use Illuminate\Support\Facades\Validator;

class MetricController extends Controller
{
    use ResponseTrait;
    public function getAll(){

        $metricsList = Metric::get();
        return $this->returnApiResponse(200, 'Metrics list',$metricsList);
    }


function getEvaluationDataByMetric(Request $request) {

    // return auth()->user();
    // Define validation rules for user_id and metric_id
    $validator = Validator::make($request->all(), [
        'metric_id' => 'required|integer|exists:metrics,id' // Checks if metric_id exists in the metrics table
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        // Return a 400 error with validation error messages
        return $this->returnApiResponse(400, $validator->errors()->first(),[] );
    }

    $userId = auth()->user()->id;
    $metricId = $request['metric_id'];
    $currentDate = Carbon::now();
    $threeMonthsAgo = $currentDate->copy()->subMonths(3);

    // $data = UserEvaluation::where(['metric_id' => $metricId, 'user_id' => $userId])
    //     ->select(
    //         'metric_parameter_id',
    //         \DB::raw('SUM(trial_1 IS NOT NULL) as trial_1_count'),
    //         \DB::raw('SUM(trial_2 IS NOT NULL) as trial_2_count'),
    //         \DB::raw('SUM(trial_3 IS NOT NULL) as trial_3_count'),
    //         \DB::raw('(SUM(trial_1 IS NOT NULL) + SUM(trial_2 IS NOT NULL) + SUM(trial_3 IS NOT NULL)) / 3 as avg_trials_count')
    //     )
    //     ->with('parameter.userEvaluations') // Ensure this relationship is correctly defined
    //     ->groupBy('metric_parameter_id')
    //     ->get();

    // // Calculate average and progression over the last three months
    // foreach ($data as $item) {
    //     // Calculate the average for the last three months
    //     $avgLastThreeMonths = UserEvaluation::where(['metric_id' => $metricId, 'user_id' => $userId])
    //         ->where('metric_parameter_id', $item->metric_parameter_id)
    //         ->whereBetween('created_at', [$threeMonthsAgo, $currentDate])
    //         ->select(
    //             DB::raw('AVG((trial_1 + trial_2 + trial_3) / 3) as avg_last_three_months')
    //         )
    //         ->value('avg_last_three_months');
        
    //     if ($avgLastThreeMonths === null) {
    //         // Set progression to null or some other indicator if there's no historical data
    //         $item->progression = null;
    //     } else {
    //         // Calculate the progression as the change from the last three-month average to the current average
    //         $item->progression = $item->avg_trials_count - $avgLastThreeMonths;
    //     }
    // }

    $data = UserEvaluation::where(['metric_id' => $metricId, 'user_id' => $userId])
    ->select(
        'metric_parameter_id',
        'trial_1',
        'trial_2',
        'trial_3',
        DB::raw('(trial_1 + trial_2 + trial_3) / 3 as latest_avg'),
        DB::raw('(
            (trial_1 + trial_2 + trial_3) / 3 
            - (
                SELECT (prev.trial_1 + prev.trial_2 + prev.trial_3) / 3
                FROM user_evaluations as prev
                WHERE prev.metric_parameter_id = user_evaluations.metric_parameter_id
                  AND prev.id < user_evaluations.id
                  AND prev.metric_id = user_evaluations.metric_id
                  AND prev.user_id = user_evaluations.user_id
                ORDER BY prev.id DESC
                LIMIT 1
            )
        ) as avg_difference')
    )
    ->whereIn('id', function ($query) use ($metricId, $userId) {
        $query->select(DB::raw('MAX(id)'))
              ->from('user_evaluations')
              ->where(['metric_id' => $metricId, 'user_id' => $userId])
              ->groupBy('metric_parameter_id');
    })
    ->with(['parameter.userEvaluations'])
    ->get();




    



    return $this->returnApiResponse(200, 'Metric detail', $data);
}

    

}
