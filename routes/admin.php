<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AgeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExerciseProgramController;
use App\Http\Controllers\Admin\ExperienceLevelController;
use App\Http\Controllers\Admin\NutritionProgramController;
use App\Http\Controllers\Admin\OnlineTrainingPlanController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StreamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserExerciseProgramController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\LiveStreamController;
use App\Http\Controllers\Admin\MetricController;
use App\Http\Controllers\Admin\UserEvaluationController;
use App\Http\Controllers\Admin\ParameterController;
use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AdminLoginController::class, 'adminIndexLogin'])->name('admin.login');
Route::post('/login', [AdminLoginController::class, 'AdminAttemptLogin'])->name('admin.attempt.login');

Route::name('admin.')->group(function () {

    /* Subscriptions */
    Route::post('/subscriptions/create', [StreamController::class, 'createSubscription'])->name('subscriptions.create');
    Route::get('/subscriptions/mark-subscribed/{user}', [StreamController::class, 'markAsSubscribed'])->name('subscriptions.markSubscribed');
    Route::post('/subscriptions/pause/{user}', [StreamController::class, 'pauseSubscription'])->name('subscriptions.pause');
    Route::post('/subscriptions/{user}/resume', [StreamController::class, 'resumeSubscription'])->name('subscriptions.resume');
    Route::post('/subscriptions/cancel/{user}', [StreamController::class, 'cancelSubscription'])->name('subscriptions.cancel');

    /* Dashboard */
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password', [DashboardController::class, 'updatePassword'])->name('password.update');

    /* Testimonial */
    Route::prefix('testimonial')->name('testimonial.')->group(function () {

        Route::get('/', [TestimonialController::class, 'index'])->name('list');
        Route::get('/create', [TestimonialController::class, 'create'])->name('create');
        Route::post('/save', [TestimonialController::class, 'save'])->name('save');
        Route::post('/update', [TestimonialController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [TestimonialController::class, 'delete'])->name('delete');

    });

    /* Streaming Plan */
    Route::prefix('streaming/plan')->name('streaming.')->group(function () {
            
        Route::get('/list', [StreamController::class, 'index'])->name('list');
        Route::get('/create', [StreamController::class, 'create'])->name('create');
        Route::post('/save', [StreamController::class, 'save'])->name('save');
        Route::post('/update', [StreamController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [StreamController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [StreamController::class, 'delete'])->name('delete');

    });

    /* Live Streaming */
    Route::prefix('live/streaming')->name('live.streaming.')->group(function () {

        Route::get('/list', [LiveStreamController::class, 'index'])->name('list');
        Route::get('/stream', [LiveStreamController::class, 'stream'])->name('stream');
        Route::post('/save', [LiveStreamController::class, 'save'])->name('save');
        Route::post('/start', [LiveStreamController::class, 'startSession'])->name('start');
        Route::post('/end', [LiveStreamController::class, 'endSession'])->name('end');
        Route::post('/stream-offer', [LiveStreamController::class, 'makeStreamOffer'])->name('stream.offer');
        Route::post('/time/left', [LiveStreamController::class, 'getTimeLeft'])->name('time.left');

    });

    /* Old Exercise Program */
    Route::prefix('exercise/program')->name('exercise.program.')->group(function () {

        Route::get('/list', [ExerciseProgramController::class, 'index'])->name('list');
        Route::post('/save', [ExerciseProgramController::class, 'save'])->name('save');
        Route::get('/edit/{uuid}', [ExerciseProgramController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [ExerciseProgramController::class, 'delete'])->name('delete');
        Route::post('/video/upload', [ExerciseProgramController::class, 'saveVideo'])->name('video.upload');
        Route::post('/info/save', [ExerciseProgramController::class, 'infoSave'])->name('info.save');
        Route::post('/sort', [ExerciseProgramController::class, 'infoSort'])->name('order');
        Route::post('/status/change', [ExerciseProgramController::class, 'statusChange'])->name('status.change');
        Route::post('/add/week', [ExerciseProgramController::class, 'AddNewWeek'])->name('add.week');
        Route::post('/update-title', [ExerciseProgramController::class, 'updateTitle'])->name('update-title');
        Route::get('/status', [ExerciseProgramController::class, 'WeekStatus'])->name('week.status');
        Route::get('/delete/week/{week_id}', [ExerciseProgramController::class, 'DeleteWeek'])->name('delete.week');

    });

    /*  Nutrition Program */
    Route::prefix('nutrition/program')->name('nutrition.program.')->group(function () {

        Route::get('/list', [NutritionProgramController::class, 'index'])->name('list');
        Route::post('/save', [NutritionProgramController::class, 'save'])->name('save');
        Route::get('/edit/{uuid}', [NutritionProgramController::class, 'edit'])->name('edit');
        // Route::post('/video/upload',[ExerciseProgramController::class, 'saveVideo'])->name('video.upload');
        Route::post('/info/save', [NutritionProgramController::class, 'infoSave'])->name('info.save');
        // Route::post('/sort',[ExerciseProgramController::class, 'infoSort'])->name('order');
        Route::post('/status/change', [NutritionProgramController::class, 'statusChange'])->name('status.change');

    });

    /* Users-livestream */
    Route::get('live-stream/users/list', [StreamController::class, 'UsersList'])->name('live-stream.users.list');
    Route::get('/user/{user}/logs', [StreamController::class, 'getUserLogs'])->name('user.logs');

    /* Users Exercise Program */
    Route::prefix('users')->name('users.')->group(function () {

        Route::get('/list', [UserExerciseProgramController::class, 'index'])->name('list');
        Route::get('/exercise/program/edit/{uuid}', [UserExerciseProgramController::class, 'edit'])->name('edit');
        Route::post('/video/upload', [UserExerciseProgramController::class, 'saveVideo'])->name('video.upload');
        Route::post('/info/save', [UserExerciseProgramController::class, 'infoSave'])->name('info.save');
        Route::post('/sort', [UserExerciseProgramController::class, 'infoSort'])->name('order');
        Route::get('/status', [UserExerciseProgramController::class, 'WeekStatus'])->name('week.status');
        Route::get('/delete/week/{week_id}', [UserExerciseProgramController::class, 'DeleteWeek'])->name('delete.week');
        Route::get('/{user}/logs', [StreamController::class, 'showUserLogs'])->name('logs.show');

    });

    /* Users Newsletter */
    Route::prefix('newsletter')->name('newsletter.')->group(function () {

        Route::get('/list', [DashboardController::class, 'newsLetter'])->name('list');
        Route::get('/export', [DashboardController::class, 'newsLetterExport'])->name('export');

    });

    /* Users In Person Contact */
    Route::prefix('in/person')->name('in.person.')->group(function () {

        Route::get('/list', [DashboardController::class, 'inPersonContact'])->name('list');
        Route::post('/list', [DashboardController::class, 'inPersonContactReply'])->name('reply');
                
    });

    /* Online Training Plan */
    Route::prefix('online/training/plan')->name('online.training.plan.')->group(function () {

        Route::get('/list', [OnlineTrainingPlanController::class, 'index'])->name('list');
        Route::get('/create', [OnlineTrainingPlanController::class, 'create'])->name('create');
        Route::post('/save', [OnlineTrainingPlanController::class, 'save'])->name('save');
        Route::post('/update', [OnlineTrainingPlanController::class, 'update'])->name('update');
        Route::get('/edit/{id}', [OnlineTrainingPlanController::class, 'edit'])->name('edit');

    });

    /* Metrics */
    Route::prefix('metrics')->name('metrics.')->group(function () {

        Route::get('/', [MetricController::class, 'index'])->name('list'); 
        // Route::get('/{id}',[MetricController::class,'getById'])->name('detail');
        Route::get('/create', [MetricController::class, 'create'])->name('create');
        Route::post('/save', [MetricController::class, 'save'])->name('save');
        Route::post('/save', [MetricController::class, 'store'])->name('store');    // for merge module
        Route::get('/get/{id}', [MetricController::class, 'getById'])->name('get');
        Route::post('/update', [MetricController::class, 'update'])->name('update');
        Route::post('/update', [MetricController::class, 'updateMetric'])->name('updateMetric');   // for merge module
        Route::get('/edit/{id}', [MetricController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [MetricController::class, 'delete'])->name('delete');

    });
    Route::get('/get-parameters/{metricId}', [ParameterController::class, 'getParameters']);

    /* User Evaluation */
    Route::prefix('user_evaluation')->name('user_evaluation.')->group(function () {

        Route::get('/{userId}', [UserEvaluationController::class, 'index'])->name('index');
        Route::get('/create/{userId}', [UserEvaluationController::class, 'create'])->name('create');
        Route::get('/profile/{userId}', [UserEvaluationController::class, 'userProfile'])->name('user.profile');
        Route::get('/history_view/{userId}', [UserEvaluationController::class, 'historyView'])->name('user.evaluation');
        Route::get('/history/{userId}/{metricId}', [UserEvaluationController::class, 'history'])->name('user.evaluation');
        Route::post('/save', [UserEvaluationController::class, 'save'])->name('save');
        // Route::post('/update', [MetricController::class, 'update'])->name('update');
        // Route::get('/edit/{id}', [MetricController::class, 'edit'])->name('edit');
        // Route::get('/delete/{id}', [MetricController::class, 'delete'])->name('delete');

    });

    /* CMS */
    Route::prefix('cms')->name('cms.')->group(function () {

        Route::get('/seo', [SettingController::class, 'siteSEO'])->name('seo');
        Route::get('/about', [SettingController::class, 'about'])->name('about');
        Route::post('/about', [SettingController::class, 'aboutSave'])->name('about.submit');
        Route::get('/slider', [SliderController::class, 'index'])->name('slider');
        Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/slider/save', [SliderController::class, 'save'])->name('slider.save');
        Route::post('/slider/update', [SliderController::class, 'update'])->name('slider.update');
        Route::get('/slider/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::get('/slider/delete/{id}', [SliderController::class, 'delete'])->name('slider.delete');

        // Site Configuration Route
        Route::get('/site/configuration', [SettingController::class, 'siteConfig'])->name('site.config');
        Route::post('/site/configuration', [SettingController::class, 'settingSave'])->name('site.config.submit');

        // Privacy Policy
        Route::get('/privacy/policy', [SettingController::class, 'privacyPolicy'])->name('privacy');
        Route::post('/privacy/policy', [SettingController::class, 'privacyPolicySave'])->name('privacy.submit');
        Route::get('/term/condition', [SettingController::class, 'termCondition'])->name('term');
        Route::post('/term/condition', [SettingController::class, 'termConditionSave'])->name('term.submit');

        //Age Focus
        Route::prefix('age')->name('age.')->group(function () {

            Route::get('/list', [AgeController::class, 'index'])->name('list');
            Route::post('/save', [AgeController::class, 'save'])->name('save');
            Route::post('/update', [AgeController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [AgeController::class, 'delete'])->name('delete');

        });

        //equipment
        Route::prefix('equipment')->name('equipment.')->group(function () {

                Route::get('/list', [EquipmentController::class, 'index'])->name('list');
                Route::post('/save', [EquipmentController::class, 'save'])->name('save');
                Route::post('/update', [EquipmentController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [EquipmentController::class, 'delete'])->name('delete');

        });

        //experience level
        Route::prefix('experience/level')->name('experience.level.')->group(function () {

            Route::get('/list', [ExperienceLevelController::class, 'index'])->name('list');
            Route::post('/save', [ExperienceLevelController::class, 'save'])->name('save');
            Route::post('/update', [ExperienceLevelController::class, 'update'])->name('update');
            Route::get('/delete/{id}', [ExperienceLevelController::class, 'delete'])->name('delete');

        });

        //New Routes for Pages
        //admin.cms.home_page_setting
        Route::get('/home-page-setting', [\App\Http\Controllers\PagesController::class, 'homePageSetting'])->name('home_page_setting');

        //saveOrUpdateHomePageSetting
        Route::post('save_or_update_home_page_setting', [\App\Http\Controllers\PagesController::class, 'saveOrUpdateHomePageSetting'])->name('save_or_update_home_page_setting');

        //    in_person_page_setting
        Route::get('/in-person-page-setting', [\App\Http\Controllers\PagesController::class, 'inPersonPageSetting'])->name('in_person_page_setting');
        Route::post('save_or_update_in_person_page_setting', [\App\Http\Controllers\PagesController::class, 'saveOrUpdate'])->name('save_or_update_in_person_page_setting');

        //online_page_setting
        Route::get('/online-page-setting', [\App\Http\Controllers\PagesController::class, 'onlinePageSetting'])->name('online_page_setting');
        Route::post('save_or_update_online_page_setting', [\App\Http\Controllers\PagesController::class, 'saveOrUpdateOnlinePageSetting'])->name('save_or_update_online_page_setting');

        // online_page_slider_setting
        Route::get('/online-page-slider-setting', [\App\Http\Controllers\PagesController::class, 'onlinePageSliderSetting'])->name('online_page_slider_setting');
        Route::post('save_or_update_online_page_slider_setting', [\App\Http\Controllers\PagesController::class, 'saveOrUpdateOnlinePageSliderSetting'])->name('save_or_update_online_page_slider_setting');

        //delete_online_page_slider
        Route::get('/delete_online_page_slider', [\App\Http\Controllers\PagesController::class, 'delete_online_page_slider'])->name('delete_online_page_slider');
        
        //Blog routes
        Route::get('/blogs_page_setting', [\App\Http\Controllers\PagesController::class, 'blogs_page_setting'])->name('blogs_page_setting');
        Route::get('/create_blog', [\App\Http\Controllers\PagesController::class, 'create_blog'])->name('create_blog');
        Route::post('/save_blog', [\App\Http\Controllers\PagesController::class, 'save_blog'])->name('save_blog');
        Route::get('/delete_blog', [\App\Http\Controllers\PagesController::class, 'delete_blog'])->name('delete_blog');


        // Education Hub routes
        Route::get('/education_hub_page_setting', [\App\Http\Controllers\EducationHubController::class, 'education_hub_page_setting'])->name('education_hub_page_setting');
        Route::get('/create_education_hub', [\App\Http\Controllers\EducationHubController::class, 'create_education_hub'])->name('create_education_hub');
        Route::post('/save_education_hub', [\App\Http\Controllers\EducationHubController::class, 'save_education_hub'])->name('save_education_hub');
        Route::get('/delete_education_hub', [\App\Http\Controllers\EducationHubController::class, 'delete_education_hub'])->name('delete_education_hub');

        // faq page routes

        Route::get('faqs', [\App\Http\Controllers\PagesController::class, 'faqs'])->name('faqs');
        Route::post('save/faq', [\App\Http\Controllers\PagesController::class, 'save_faq'])->name('save_faq');
        Route::get('delete/faq', [\App\Http\Controllers\PagesController::class, 'delete_faq'])->name('delete_faq');
        Route::get('edit/faq', [\App\Http\Controllers\PagesController::class, 'edit_faq'])->name('edit_faq');
        Route::post('update/faq', [\App\Http\Controllers\PagesController::class, 'update_faq'])->name('update_faq');

    });

    /* New Exercise program routes */
    Route::prefix('new/exercise')->name('new.exercise.')->group(function () {

        Route::get('/manage', [\App\Http\Controllers\Admin\NewExerciseController::class, 'manage_exercise'])->name('manage');

        //create_exercise_program
        Route::get('/create-program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'create_exercise_program'])->name('create.program');

        //dupilcate_exercise_program
        //Route::get('/duplicate-program/{id}', [\App\Http\Controllers\Admin\NewExerciseController::class, 'duplicate_exercise'])->name('duplicate.program');
        // Duplicate exercise program - NEW ROUTES
        Route::get('/duplicate-program/{id}', [\App\Http\Controllers\Admin\NewExerciseController::class, 'duplicate_exercise_program'])->name('duplicate.program');
        Route::post('/process-duplicate-program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'process_duplicate_program'])->name('process_duplicate_program');
        
        // Original duplicate route (for simple duplication without interface)
        Route::get('/duplicate-simple/{id}', [\App\Http\Controllers\Admin\NewExerciseController::class, 'duplicate_exercise'])->name('duplicate.simple');   
            
        //save_create_program
        Route::post('/save-create-program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'save_create_program'])->name('save_create_program');
        Route::post('/update-create-program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'update_create_program'])->name('update_create_program');

        //Delete Exercise Program
        Route::get('delete-exercise/{id}', [\App\Http\Controllers\Admin\NewExerciseController::class, 'delete'])->name('delete_exercise');

        //save_day_exercise_item
        Route::post('save-day-exercise-item', [\App\Http\Controllers\Admin\NewExerciseController::class, 'save_day_exercise_item'])->name('save_day_exercise_item');

        //delete_item
        Route::get('delete-item', [\App\Http\Controllers\Admin\NewExerciseController::class, 'delete_item'])->name('delete_item');
        Route::get('add_days_or_weeks', [\App\Http\Controllers\Admin\NewExerciseController::class, 'add_days_or_weeks'])->name('add_days_or_weeks');
        Route::get('delete_days_or_weeks', [\App\Http\Controllers\Admin\NewExerciseController::class, 'delete_days_or_weeks'])->name('delete_days_or_weeks');
        Route::get('assign_exercise', [\App\Http\Controllers\Admin\NewExerciseController::class, 'assign_exercise'])->name('assign_exercise');

        //assign_program
        Route::post('assign_program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'assign_program'])->name('assign_program');
        Route::post('check_assigned_program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'checkUserExerciseExistanceById'])->name('check_assigned_program');;
        Route::get('deassign_program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'deassign_program'])->name('deassign_program');

        //day title
        Route::get('add_title', [\App\Http\Controllers\Admin\NewExerciseController::class, 'add_title'])->name('add_title');
        Route::post('update_title', [\App\Http\Controllers\Admin\NewExerciseController::class, 'update_title'])->name('update_title');

        // Unified Exercise Management
        Route::get('exercise-management', [\App\Http\Controllers\Admin\ExerciseListController::class, 'unified_management'])->name('unified_exercise_management');

        // Additional route for AJAX data loading
        Route::get('exercise-list/{id}/get', [\App\Http\Controllers\Admin\ExerciseListController::class, 'get_exercise_data'])->name('get_exercise_data');
        
        //new routes for livewire
        // Copy exercise program
        Route::get('/copy-program', [\App\Http\Controllers\Admin\NewExerciseController::class, 'copy_exercise_program'])->name('copy_program');
        
        // Bulk update exercises
        Route::post('/bulk-update-exercises', [\App\Http\Controllers\Admin\NewExerciseController::class, 'bulk_update_exercises'])->name('bulk_update_exercises');
        
        // Create exercise with Livewire (updated route)
        Route::get('create-exercise', [\App\Http\Controllers\Admin\NewExerciseController::class, 'create_exercise'])->name('create_exercise');
            
        //   Categories
        Route::get('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'categories'])->name('categories');
        Route::get('create-category', [\App\Http\Controllers\Admin\CategoryController::class, 'create_category'])->name('create_category');
        Route::post('save-category', [\App\Http\Controllers\Admin\CategoryController::class, 'save_category'])->name('save_category');
        Route::get('delete-category', [\App\Http\Controllers\Admin\CategoryController::class, 'delete_category'])->name('delete_category');
        Route::get('edit-category', [\App\Http\Controllers\Admin\CategoryController::class, 'edit_category'])->name('edit_category');
        Route::post('update-category', [\App\Http\Controllers\Admin\CategoryController::class, 'update_category'])->name('update_category');

        //        Bodyparts
        Route::get('bodyparts', [\App\Http\Controllers\Admin\BodypartController::class, 'bodyparts'])->name('bodyparts');
        Route::get('create-bodypart', [\App\Http\Controllers\Admin\BodypartController::class, 'create_bodypart'])->name('create_bodypart');
        Route::post('save-bodypart', [\App\Http\Controllers\Admin\BodypartController::class, 'save_bodypart'])->name('save_bodypart');
        Route::get('delete-bodypart', [\App\Http\Controllers\Admin\BodypartController::class, 'delete_bodypart'])->name('delete_bodypart');
        Route::get('edit-bodypart', [\App\Http\Controllers\Admin\BodypartController::class, 'edit_bodypart'])->name('edit_bodypart');
        Route::post('update-bodypart', [\App\Http\Controllers\Admin\BodypartController::class, 'update_bodypart'])->name('update_bodypart');

        //exercise_style
        Route::get('exercise-style', [\App\Http\Controllers\Admin\ExerciseStyleController::class, 'exercise_style'])->name('exercise_style');
        Route::get('create-exercise-style', [\App\Http\Controllers\Admin\ExerciseStyleController::class, 'create_exercise_style'])->name('create_exercise_style');
        Route::post('save-exercise-style', [\App\Http\Controllers\Admin\ExerciseStyleController::class, 'save_exercise_style'])->name('save_exercise_style');
        Route::get('delete-exercise-style', [\App\Http\Controllers\Admin\ExerciseStyleController::class, 'delete_exercise_style'])->name('delete_exercise_style');
        Route::get('edit-exercise-style', [\App\Http\Controllers\Admin\ExerciseStyleController::class, 'edit_exercise_style'])->name('edit_exercise_style');
        Route::post('update-exercise-style', [\App\Http\Controllers\Admin\ExerciseStyleController::class, 'update_exercise_style'])->name('update_exercise_style');

        //    Exercise List Create
        Route::get('exercise-list', [\App\Http\Controllers\Admin\ExerciseListController::class, 'exercise_list'])->name('exercise_list');
        Route::get('create-exercise-list', [\App\Http\Controllers\Admin\ExerciseListController::class, 'create_exercise_list'])->name('create_exercise_list');
        Route::post('save-exercise-list', [\App\Http\Controllers\Admin\ExerciseListController::class, 'save_exercise_list'])->name('save_exercise_list');
        Route::get('delete-exercise-list', [\App\Http\Controllers\Admin\ExerciseListController::class, 'delete_exercise_list'])->name('delete_exercise_list');
        Route::get('edit-exercise-list', [\App\Http\Controllers\Admin\ExerciseListController::class, 'edit_exercise_list'])->name('edit_exercise_list');
        Route::get('view-exercise-list', [\App\Http\Controllers\Admin\ExerciseListController::class, 'view_exercise_list'])->name('view_exercise_list');
        Route::post('update-exercise-list', [\App\Http\Controllers\Admin\ExerciseListController::class, 'update_exercise_list'])->name('update_exercise_list');


        // Alternate exercise add update routes
        Route::post('save-alternate-exercise', [\App\Http\Controllers\Admin\ExerciseListController::class, 'save_alternate_exercise'])->name('save_alternate_exercise');
        Route::post('update-alternate-exercise', [\App\Http\Controllers\Admin\ExerciseListController::class, 'update_alternate_exercise'])->name('update_alternate_exercise');
        Route::get('alternate-exercise/{id}/get', [\App\Http\Controllers\Admin\ExerciseListController::class, 'get_alternate_exercise'])->name('get_alternate_exercise');
        Route::get('exercise-list/{id}/alternates', [\App\Http\Controllers\Admin\ExerciseListController::class, 'get_alternate_exercises'])->name('get_alternate_exercises');
        Route::post('alternate-exercise/{id}/delete', [\App\Http\Controllers\Admin\ExerciseListController::class, 'delete_alternate_exercise'])->name('delete_alternate_exercise');
    });

    //testing
    Route::get('testing/{type}/{id}', [\App\Http\Controllers\Admin\ExerciseListController::class, 'testing_type'])->name('testing_type');
    Route::get('delete_testing/{id}', [\App\Http\Controllers\Admin\ExerciseListController::class, 'delete_testing'])->name('delete_testing');
    Route::post('save_testing', [\App\Http\Controllers\Admin\ExerciseListController::class, 'save_testing'])->name('save_testing');
    
    //monitoring
    Route::get('monitoring/{id}', [\App\Http\Controllers\Admin\ExerciseListController::class, 'monitoring'])->name('monitoring');
    Route::get('monitoring-data/{uid}/{body_part_id}', [\App\Http\Controllers\Admin\ExerciseListController::class, 'getMonitoringData'])->name('monitoring.data');
    Route::post('save_monitoring', [\App\Http\Controllers\Admin\ExerciseListController::class, 'save_monitoring'])->name('save_monitoring');
    Route::get('delete_monitoring/{id}', [\App\Http\Controllers\Admin\ExerciseListController::class, 'delete_monitoring'])->name('delete_monitoring');

    //form check
    Route::get('form_check/{id}', [\App\Http\Controllers\Admin\ExerciseListController::class, 'form_check'])->name('form_check');
    Route::post('save_form_check', [\App\Http\Controllers\Admin\ExerciseListController::class, 'save_form_check'])->name('save_form_check');
    
    //Notification routes
    Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('notifications.show');

});

