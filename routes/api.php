<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('oauth/token', [AccessTokenController::class, 'issueToken'])->name('passport.token');
Route::middleware(['log.api'])->group(function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('recording-completed', 'App\Http\Controllers\HomeController@saveZoomRecordingData');
    
    ///
    //Route::group(['prefix' => '/v1', 'middleware' => ['cors']], function () {
    Route::group(['prefix' => '/v1'], function () {
        //register_user,login
        
        Route::post('registerr', [\App\Http\Controllers\Api\UserController::class, 'register_user']);
        Route::post('crm_register', [\App\Http\Controllers\Api\UserController::class, 'registerUserForCRM']);
        
        Route::post('login', [\App\Http\Controllers\Api\UserController::class, 'login_user']);
        Route::post('forgot_password', [\App\Http\Controllers\Api\UserController::class, 'forgotPassword']);
        Route::middleware('cors')->group(function () {
            Route::middleware('auth:api')->group(function () {
    
                Route::post('make_favourite', [\App\Http\Controllers\Api\FavouriteController::class, 'create']);
                Route::post('remove_favourite', [\App\Http\Controllers\Api\FavouriteController::class, 'remove']);
                Route::get('favourite_exercise_list', [\App\Http\Controllers\Api\FavouriteController::class, 'getAll']);
                Route::get('favourite_exercise_list/{bodyPartId}', [\App\Http\Controllers\Api\FavouriteController::class, 'getExerciseByBodyPartId']);
    
                Route::post('update/profile', [\App\Http\Controllers\Api\UserController::class, 'update_profile']);
                //da
                Route::get('exercise_details', [\App\Http\Controllers\Api\ExerciseController::class, 'exerciseDetailById']);
                Route::get('dashboard/exercises', [\App\Http\Controllers\Api\ExerciseController::class, 'dashboard_exercises']);
                  //my completed exercise programs
                Route::get('dashboard/completed_exercises', [\App\Http\Controllers\Api\ExerciseController::class, 'mycompleted_exercises']);
                
                Route::get('all/exercises', [\App\Http\Controllers\Api\ExerciseController::class, 'all_exercises']);
                Route::get('my/exercises', [\App\Http\Controllers\Api\ExerciseController::class, 'my_exercises']);
                Route::get('my/exercises/alternate', [\App\Http\Controllers\Api\ExerciseController::class, 'alternate_exercises']);
                Route::post('swap/exercise', [\App\Http\Controllers\Api\ExerciseController::class, 'swap_exercise']);
                Route::post('log/exercise', [\App\Http\Controllers\Api\ExerciseController::class, 'log_exercise']);
                //get user logs
                Route::get('exercise/logs', [\App\Http\Controllers\Api\ExerciseController::class, 'get_exercise_logs']);
                
                //program end api
                Route::post('program/end', [\App\Http\Controllers\Api\ExerciseController::class, 'program_end']);
                
                //get stored and delete exercise notes
                Route::post('exercise/save-note', [\App\Http\Controllers\Api\ExerciseController::class, 'save_note']);
                Route::get('exercise/get-notes', [\App\Http\Controllers\Api\ExerciseController::class, 'get_notes']);
                Route::delete('exercise/delete-note', [\App\Http\Controllers\Api\ExerciseController::class, 'delete_note']);
                Route::get('exercise/get-day-notes', [\App\Http\Controllers\Api\ExerciseController::class, 'get_day_notes']);
                
                Route::get('list/exercises', [\App\Http\Controllers\Api\ExerciseController::class, 'getExerciseItems']);
                //blogs
                Route::get('all/blogs', [\App\Http\Controllers\Api\BlogController::class, 'all_blogs']);
                Route::get('education', [\App\Http\Controllers\Api\BlogController::class, 'education']);
                Route::get('exercise/item', [\App\Http\Controllers\Api\ExerciseController::class, 'getExerciseItem']);
                Route::group(['prefix' => 'custom/plan'], function () {
                    Route::get('/', [\App\Http\Controllers\Api\ExerciseController::class, 'get_plans']);
                    //create
                    Route::post('create', [\App\Http\Controllers\Api\ExerciseController::class, 'create_plan']);
                    //add day
                    Route::post('add/day', [\App\Http\Controllers\Api\ExerciseController::class, 'add_day']);
                    //add exercise in day
                    Route::post('add/exercise', [\App\Http\Controllers\Api\ExerciseController::class, 'add_exercise']);
                });
                //categories
                Route::get('categories', [\App\Http\Controllers\Api\ExerciseController::class, 'categories']);
                Route::get('genders', [\App\Http\Controllers\Api\ExerciseController::class, 'genders']);
                Route::get('bodyparts', [\App\Http\Controllers\Api\ExerciseController::class, 'bodyparts']);
                Route::get('exercise/style', [\App\Http\Controllers\Api\ExerciseController::class, 'exercise_style']);
                Route::get('testing', [\App\Http\Controllers\Api\ExerciseController::class, 'testings']);
               // Route::get('monitoring', [\App\Http\Controllers\Api\ExerciseController::class, 'monitoring']);
    
                Route::get('metrics', [\App\Http\Controllers\Api\MetricController::class, 'getAll']);
                Route::get('metrics/details', [\App\Http\Controllers\Api\MetricController::class, 'getEvaluationDataByMetric']);
                
    
    
                Route::get('form/check', [\App\Http\Controllers\Api\ExerciseController::class, 'form_check']);
                Route::post('save/form/check', [\App\Http\Controllers\Api\ExerciseController::class, 'save_form_check']);
                Route::get('update_subscription_status', [\App\Http\Controllers\Api\UserController::class, 'updateSubscriptionStatus']);
                Route::post('payout', [\App\Http\Controllers\Api\PaymentController::class, 'payoutSubmit']);
                
                Route::get('monitoring', [\App\Http\Controllers\Api\MonitoringController::class, 'get']);
                Route::get('body_part_list', [\App\Http\Controllers\Api\MonitoringController::class, 'getBodyPartList']);
                
    
            });
        });
    });

});