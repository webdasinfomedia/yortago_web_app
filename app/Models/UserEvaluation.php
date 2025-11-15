<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MetricParameter;

class UserEvaluation extends Model
{
    use HasFactory;

    protected $table = "user_evaluations";
    protected $fillable = [
        'user_id',
        'metric_id',
        'metric_parameter_id',
        'trial_1',
        'trial_2',
        'trial_3'
    ];

    public $timestamps = true; 

    public function metric() {
        return $this->belongsTo(Metric::class);
    }

    public function parameter()
    {
        return $this->belongsTo(MetricParameter::class, 'metric_parameter_id');
    }

}
