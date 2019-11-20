<?php

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
use App\Mail\mailme;
Route::get('/', function () {
   Mail::to('boris.biswas@gmail.com')->send(new mailme);
return view('emails.contact');
});


Route::get('/broadcast', function() {

        event(new \App\Events\NewNotification('Sent from my Laravel application'));

        return 'ok';
});

// Route::get('/', function () {
//     return view('welcome');
// });

// dd(bcrypt('123456'));
// dd(Hash::check('123456', Hash::make('123456')));
// dd(Auth::attempt(['email' => 'admin@app.com', 'password' => '123456']));
// dd(Auth::attempt(['email' => 'admin@app.com', 'password' => '123456']));


// $user = new App\User;
// $user->email = 'joe@gmail.com';
// $user->password = Hash::make('123456');

// if ( ! ($user->save()))
// {
//  dd('user is not being saved to database properly - this is the problem');
// }

// if ( ! (Hash::check('123456', Hash::make('123456'))))
// {
//  dd('hashing of password is not working correctly - this is the problem');
// }

// if ( ! (Auth::attempt(array('email' => 'joe@gmail.com', 'password' => '123456'))))
// {
//  dd('storage of user password is not working correctly - this is the problem');
// }

// else
// {
//  dd('everything is working when the correct data is supplied - so the problem is related to your forms and the data being passed to the function');
// }
