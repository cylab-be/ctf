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

use App\Challenge;

Route::get('/', function () {
    return redirect(route('challenges'));
});

Auth::routes();

Route::resource('app/challenges', 'ChallengeController');
Route::get('app/challenges/{challenge}/access', 'ChallengeController@access');
Route::get('app/challenges/{challenge}/start', 'ChallengeController@start');
Route::get('app/challenges/{challenge}/statistics', 'ChallengeController@statistics');
Route::post('app/challenges/{challenge}/set/add', 'ChallengeController@addSet');
Route::delete('app/challenges/{challenge}/set/{set}', 'ChallengeController@removeSet');
Route::resource('app/sets', 'SetController');
Route::resource('app/sets.questions', 'QuestionController');
Route::resource('app/users', 'UserController');
Route::post('app/users/{user}/admin', 'UserController@toggleAdmin');

Route::get('app/submissions', 'SubmissionController@index');


// user routes
Route::get('challenges', function () {
    return view("challenge.index", ["challenges" => Challenge::upcoming()]);
})->name('challenges');

// No auth required...
Route::get('challenges/{challenge}/scoreboard', function (Challenge $challenge) {
    return view('challenge.scoreboard', ['challenge' => $challenge]);
})->name('scoreboard');

// Must be authenticated
Route::get('challenges/{challenge}/join', 'UserChallengeController@join');
Route::post('challenges/{challenge}/join', 'UserChallengeController@storeJoin');
Route::get('challenges/{challenge}', 'UserChallengeController@show');
Route::post('challenges/{challenge}/questions/{question}', 'UserChallengeController@submit');


Route::get('hall-of-fame', function () {
    return view('hall-of-fame', ['challenges' => \App\Challenge::finished()]);
})->name('hall-of-fame');


Route::get('account', 'AccountController@show');
Route::get('account/edit', 'AccountController@edit');
Route::put('account', 'AccountController@update');
Route::put('account/password', 'AccountController@updatePassword');


Route::get('help', function () {
    return view('help');
})->name('help');
