<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Metric;
use App\Models\MetricParameter;
use Illuminate\Validation\Rule;


class MetricController extends Controller
{
    public function __construct(){
        $this->middleware('is_admin');
    }

    public function index(){
        $metricsList = Metric::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.metric.index',get_defined_vars());
    }

    public function create(Request $request){

        return view('admin.metric.create')->with('title', 'Metrics');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:metrics,name',
        ]);

        $metric = Metric::create([
            'name' => $request['name']
        ]);

        $metricParameter = [];

        if (isset($request['parameter']) && is_array($request['parameter'])) {
            foreach ($request['parameter'] as $index => $item) {
                $metricParameter[] = [
                    "name" => $item,
                    "color_code" => isset($request['color']) && isset($request['color'][$index]) ? $request['color'][$index] : null,
                    'metric_id' => $metric->id
                ];
            }
        }

        MetricParameter::insert($metricParameter);

            return response()->json([
                'status' => 200,
                'redirect_url' => route('admin.metrics.list') // Ensure this route is correct
            ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:metrics,name',
        ]);

        $metric = Metric::create([
            'name' => $request['name']
        ]);

        $metricParameter = [];

        if (isset($request['parameter']) && is_array($request['parameter'])) {
            foreach ($request['parameter'] as $index => $item) {
                $metricParameter[] = [
                    "name" => $item,
                    "color_code" => isset($request['color'][$index]) ? $request['color'][$index] : null,
                    'metric_id' => $metric->id
                ];
            }
        }

        if (!empty($metricParameter)) {
            MetricParameter::insert($metricParameter);
        }

        return redirect()->route('admin.new.exercise.unified_exercise_management')
                        ->with('message', 'Metric created successfully!')->with('active_tab', 'metrics-list');
    }


        public function edit($id){

            $metric = Metric::with('parameters')->findOrFail($id);
    

            return view('admin.metric.edit', get_defined_vars())->with('title', 'Edit Metrics');

        }

        public function update(Request $request) {
            $request->validate([
                'name' => [
                    'required',
                    Rule::unique('metrics', 'name')->ignore($request->id), // Ensures unique name, ignoring current record
                ],
            ]);
        
            // Delete associated metric parameters
            MetricParameter::where('metric_id', $request['id'])->delete();
        
            // Update the metric
            Metric::find($request['id'])->update([
                'name' => $request['name']
            ]);
        
            // Prepare metric parameters for insertion
            $metricParameter = [];
        
            if (isset($request['parameter']) && is_array($request['parameter'])) {
                foreach ($request['parameter'] as $index => $item) {
                    $metricParameter[] = [
                        "name" => $item,
                        "color_code" => isset($request['color']) && isset($request['color'][$index]) ? $request['color'][$index] : null,
                        'metric_id' => $request['id']
                    ];
                }
            }
        
            // Insert new metric parameters
            MetricParameter::insert($metricParameter);
        
            // Return response
            return response()->json([
                'status' => 200,
                'redirect_url' => route('admin.metrics.list') // Ensure this route is correct
            ]);
        }

        public function updateMetric(Request $request) {
            $request->validate([
                'name' => [
                    'required',
                    Rule::unique('metrics', 'name')->ignore($request->id), // Ensures unique name, ignoring current record
                ],
            ]);
        
            // Delete associated metric parameters
            MetricParameter::where('metric_id', $request['id'])->delete();
        
            // Update the metric
            Metric::find($request['id'])->update([
                'name' => $request['name']
            ]);
        
            // Prepare metric parameters for insertion
            $metricParameter = [];
        
            if (isset($request['parameter']) && is_array($request['parameter'])) {
                foreach ($request['parameter'] as $index => $item) {
                    $metricParameter[] = [
                        "name" => $item,
                        "color_code" => isset($request['color']) && isset($request['color'][$index]) ? $request['color'][$index] : null,
                        'metric_id' => $request['id']
                    ];
                }
            }
        
            // Insert new metric parameters
            MetricParameter::insert($metricParameter);
        
            // Return response
            return redirect()->route('admin.new.exercise.unified_exercise_management')
                        ->with('message', 'Metric Updated successfully!')->with('active_tab', 'metrics-list');
        }
    
        //get metrics details for edit in exercise management module
        public function getById($id)
        {
            $metric = Metric::with('parameters')->findOrFail($id);

            return response()->json([
                'id' => $metric->id,
                'name' => $metric->name,
                'parameters' => $metric->parameters->map(function($p) {
                    return [
                        'parameter' => $p->name,
                        'color' => $p->color_code
                    ];
                })
            ]);
        }



    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            $metric = Metric::findOrFail($id);

            // Automatically delete related data using relationships
            $metric->userEvaluations()->delete();
            $metric->parameters()->delete();

            $metric->delete();
        });

        return redirect()->back()->with('message','Metric has been deleted successfully!')->with('active_tab', 'metrics-list');
    }

}
