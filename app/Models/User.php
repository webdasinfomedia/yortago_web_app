<?php



namespace App\Models;



use Carbon\Carbon;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Cashier\Billable;


use Laravel\Passport\HasApiTokens;



class User extends Authenticatable

{

    use HasApiTokens, HasFactory, Notifiable, Billable;



    /**

     * The attributes that are mass assignable.

     *

     * @var string[]

     */

    protected $guarded = [];



    /**

     * The attributes that should be hidden for serialization.

     *

     * @var array

     */

    protected $hidden = [

        'password',

        'remember_token',



        // 'subscription_name',

        // 'subscription_interval',

        // 'stripe_temp_session_id',

        // 'stripe_status',

        // 'is_subscribed',

        // 'stripe_subscription_id',

        //  'stripe_token',



    ];



    /**

     * The attributes that should be cast.

     *

     * @var array

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];



    public function age(): BelongsTo

    {

        return $this->belongsTo(Age::class, 'age_id', 'id');

    }



    public function gender(): BelongsTo

    {

        return $this->belongsTo(Gender::class, 'gender_id', 'id');

    }



    public function experience_level(): BelongsTo

    {

        return $this->belongsTo(ExperienceLevel::class, 'experience_level_id', 'id');

    }



    public function equipment(): BelongsTo

    {

        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');

    }



    public function exercise_weeks(): HasMany

    {

        return $this->hasMany(UserExerciseProgramWeek::class, 'user_id', 'id')->orderBy('created_at', 'asc');

    }



    public function userSession(): HasMany

    {

        return $this->hasMany(UserStreamSession::class, 'user_id', 'id')->orderBy('created_at', 'asc');

    }



    public function PlanValidate()

    {

        $check = StreamPlanPurchasedHistory::where(['user_id' => auth()->id(), 'status' => 1])->whereDate('end_date', '>', Carbon::now())->exists();

        return $check;

    }



    public function online_training_plan()

    {

        return $this->belongsTo(OnlineTrainingPlan::class, 'online_training_plan_id');

    }



//New Code

    public function exercises()

    {

        return $this->belongsToMany(NewExercise::class,'new_user_exercises')

            ->withPivot('start_date', 'completion_date','id')

            ->withTimestamps();

    }



    public function exerciseLogs()

    {

        return $this->hasMany(NewUserExerciseLog::class,'user_id','id');

    }



  public function subscription()

{
    // return $this->hasOne(\Laravel\Cashier\Subscription::class, 'user_id', 'id');
    return $this->hasOne(\App\Models\Subscription::class, 'user_id', 'id');

}

public function isSubscribed($name = 'Subscription')
{
    return $this->subscription()
        ->where('name', $name)
        ->where('stripe_status', 'active')
        ->exists();
}



}

