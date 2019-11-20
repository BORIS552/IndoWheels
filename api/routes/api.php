<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:api'])->get('auth/user', 'Api\Auth\UserController');
Route::middleware([])->post('auth/login', 'Api\Auth\LoginController');
Route::middleware([])->post('auth/admin/login', 'Api\Auth\AdminLoginController');
Route::middleware([])->post('auth/signup', 'Api\Auth\RegisterController');
Route::middleware([])->get('auth/otp', 'Api\Auth\OtpController@index');
Route::middleware([])->post('auth/otp', 'Api\Auth\OtpController@store');
Route::middleware([])->get('admin/users', 'Api\Admin\UserController@getUsers');

Route::middleware([])->post('admin/sendsms', 'Api\Admin\LotteryController@sendSMS');
Route::middleware([])->get('admin/whatsapp', 'Api\Admin\ContactController@sendWhatsappMessage');
// participations
Route::middleware(['auth:api'])->get('user/participations', 'Api\ParticipationController@index');
Route::middleware(['auth:api'])->post('user/participations/{lottery}', 'Api\ParticipationController@store');

// prizes
Route::middleware(['auth:api'])->get('user/prizes', 'Api\PrizeController@index');
Route::middleware(['auth:api'])->post('user/prizes/{prize}', 'Api\PrizeController@update');

//upload selfie
Route::middleware([])->post('uploadselfie', 'Api\PrizeController@uploadSelfie');


//userid
Route::middleware([])->post('userid', 'Api\ParticipationController@manipulation');

//push notification
Route::middleware([])->get('admin/sendNotification', 'Api\Admin\LotteryController@sendNotification');
Route::middleware([])->post('admin/fcm', 'Api\Admin\UserController@addFCMToken');
Route::middleware([])->post('admin/sendPushNotification', 'Api\Admin\LotteryController@sendfcmPushNotification');
Route::middleware([])->post('admin/notifyPushNotification', 'Api\Admin\LotteryController@notifyUsersPushNotification');




/*
|--------------------------------------------------------------------------
| Admin Lottery API
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->resource('lotteries', 'Api\Admin\LotteryController')->except(['create', 'edit']);
Route::middleware('auth:api')->post('lotteries/{lottery}/users', 'Api\Admin\LotteryController@users');

// Route::middleware('auth:api')->get('prizes', 'Api\Admin\PrizeController@index');
// Route::middleware('auth:api')->delete('prizes/{prize}', 'Api\Admin\PrizeController@destroy');
Route::middleware('auth:api')->resource('prizes', 'Api\Admin\PrizeController')->only(['index', 'destroy']);

Route::middleware('auth:api')->resource('banners', 'Api\Admin\BannerController')->except(['create', 'edit']);
Route::middleware('auth:api')->resource('ads', 'Api\Admin\AdController')->except(['create', 'edit']);
Route::middleware('auth:api')->resource('outlets', 'Api\Admin\OutletController')->except(['create', 'edit']);
Route::middleware('auth:api')->resource('reviews', 'Api\Admin\ReviewController')->except(['create', 'edit']);
Route::middleware('auth:api')->resource('users', 'Api\Admin\UserController')->except(['create', 'edit']);
Route::middleware('auth:api')->resource('users.images', 'Api\Admin\ImageController')->except(['create', 'edit']);

Route::middleware('auth:api')->post('profile', 'Api\Admin\ProfileController');

Route::middleware('auth:api')->post('contact', 'Api\Admin\ContactController');

Route::middleware('auth:api')->get('terms', 'Api\TermsController@index');
Route::middleware('auth:api')->post('terms', 'Api\TermsController@accept');

/*
|--------------------------------------------------------------------------
| Front end API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('user/reviews', 'Api\ReviewController@index');
Route::middleware('auth:api')->get('user/reviews/videos', 'Api\ReviewController@videos');
// Route::middleware('auth:api')->get('user/reviews', 'Api\ReviewController@index');
