<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetricParameter extends Model
{
    use HasFactory;

    protected $table = 'metrics_paramters';

    protected $fillable = [
        'metric_id',
        'name'
    ];


    public function metric() {
        return $this->belongsTo(Metric::class);
    }

    public function userEvaluations() {
        return $this->hasMany(UserEvaluation::class)->orderBy('created_at','DESC');
    }
}
