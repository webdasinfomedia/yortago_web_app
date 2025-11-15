<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NutritionWeek extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function nutrition_infos(): HasMany
    {
        return $this->hasMany(NutritionWeekInfo::class, 'nutrition_week_id', 'id');
    }
    public function nutrition_info(): HasMany
    {
        return $this->hasMany(NutritionWeekInfo::class, 'nutrition_week_id', 'id')->where('heading','!=',null);
    }
}
