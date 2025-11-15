<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MetricParameter;
use App\Models\UserEvaluation;

class Metric extends Model
{
    use HasFactory;

    protected $table = 'metrics';

    protected $fillable = [
        'name'
    ];

    public function parameters(){
        return $this->hasMany(MetricParameter::class, 'metric_id');
    }

    public function userEvaluations(){
        return $this->hasMany(UserEvaluation::class, 'metric_id');
    }
}
