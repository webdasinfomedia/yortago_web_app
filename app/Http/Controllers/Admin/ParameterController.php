<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetricParameter;

class ParameterController extends Controller
{
    public function getParameters($metricId)
    {
        $parameters = MetricParameter::where('metric_id', $metricId)->get();  // Get parameters for the selected metric
        return response()->json($parameters);  // Return parameters as JSON
    }
}
