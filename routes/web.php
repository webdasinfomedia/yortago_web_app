<?php

use App\Http\Controllers\Admin\LiveStreamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebrtcStreamingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/streaming', [WebrtcStreamingController::class, 'index']);
Route::get('/streaming/{streamId}', 'App\Http\Controllers\WebrtcStreamingController@consumer');
Route::post('/stream-offer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamOffer');
Route::post('/stream-answer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamAnswer');
Route::get('get-offered-stream/{id}', [HomeController::class, 'getOfferedStream']);

// Front end Route


Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/delete-my-account', function(){
    return view('auth.delete_account');
});
Route::post('/delete-my-account', [HomeController::class, 'deleteAccount'])->name('delete_account');

Route::get('shop',function (){
    return view('front.shop');
})->name('shop');

Route::get('product_detail',function (){
    return view('front.shop_detail');
})->name('product_detail');

Route::get('blog', [\App\Http\Controllers\PagesController::class, 'blogs'])->name('blog');
Route::get('blog_detail', [\App\Http\Controllers\PagesController::class, 'blog_detail'])->name('blog_detail');




Route::get('/home', [HomeController::class, 'home'])->name('index');
Route::get('/about/us', [HomeController::class, 'aboutUs'])->name('about.us');
Route::get('/term/condition', [HomeController::class, 'termCondition'])->name('term.condition');
Route::get('/privacy/policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/stream/rating/{stream_id?}', [HomeController::class, 'streamRating'])->name('stream.rating');
Route::get('/stream/rating/{id}/{stream_id}', [HomeController::class, 'streamRatingSubmit'])->name('stream.rating.submit');
Route::get('/live/stream', [HomeController::class, 'liveStream'])->name('live.stream');
Route::get('/live/stream/recordings', [HomeController::class, 'TrainingVideos'])->name('live.stream.recordings');
Route::post('/stream-answer', [HomeController::class, 'makeStreamAnswer'])->name('live.stream.answer');
Route::post('/join/stream/session', [HomeController::class, 'sessionStart'])->name('live.stream.answer');
Route::get('/online/training', [HomeController::class, 'onlineTraining'])->name('online.training');
Route::post('/online/training', [HomeController::class, 'onlineTrainingSave'])->name('online.training.save');
Route::get('/training', [HomeController::class, 'onlineTrainingAll'])->name('online.training.all')->middleware('UserIsSubscribed');
Route::get('/in/person', [HomeController::class, 'inPerson'])->name('in.person');
Route::get('/nutrition', [HomeController::class, 'nutrition'])->name('nutrition.all')->middleware('UserIsSubscribed');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
Route::post('/profile',[HomeController::class, 'updateProfile'])->name('profile.update');
Route::post('/password',[HomeController::class, 'updatePassword'])->name('user.password.update');
Route::post('/contact/info',[HomeController::class, 'saveContact'])->name('contact.save');
Route::post('/news/letter',[HomeController::class, 'saveNewsLetter'])->name('contact.news.letter');
Route::get('/sign/up',[HomeController::class, 'signUpPage'])->name('sign.up');
Route::get('/online/training/register',[HomeController::class, 'onlineTrainingView'])->name('online.training.register');
Route::get('/training/complete/week/{id}', [HomeController::class, 'completeWeek'])->name('online.complete.week');
Route::post('/training/save-weight', [HomeController::class, 'saveWeight'])->name('online.save.weight');

Route::get('/live/streaming/register',[HomeController::class, 'liveStreamView'])->name('live.stream.register');
Route::post('/time/left',[HomeController::class, 'getTimeLeft'])->name('time.left');
Route::get('/payout',[HomeController::class, 'payout'])->name('payout');
Route::post('/payout',[HomeController::class, 'payoutSubmit'])->name('payout.submit');
Route::post('/webhook/update/payment',[HomeController::class, 'handleWebhook'])->name('web.hook');
Route::post('/webhook/failed/payment',[HomeController::class, 'subscriptionFailed'])->name('web.hook');

Route::post('/stream-offer',[LiveStreamController::class, 'makeStreamOffer'])->name('stream.offer');
Route::get('/streaming', [WebrtcStreamingController::class, 'index']);
Route::get('/streaming/{streamId}', 'App\Http\Controllers\WebrtcStreamingController@consumer');
Route::post('/stream-offer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamOffer');
Route::post('/stream-answer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamAnswer');

Route::get('/reset_password_by_token/{token}', 'App\Http\Controllers\Api\UserController@showResetPasswordForm')->name('reset.password.form');
Route::post('/update_password', 'App\Http\Controllers\Api\UserController@resetPassword')->name('reset.password.by.token');

require __DIR__.'/auth.php';


