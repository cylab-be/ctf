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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('app/challenges', 'ChallengeController');
Route::post('app/challenges/{challenge}/set/add', 'ChallengeController@addSet');
Route::delete('app/challenges/{challenge}/set/{set}', 'ChallengeController@removeSet');
Route::resource('app/sets', 'SetController');
Route::resource('app/sets.questions', 'QuestionController');


// user routes
Route::get('challenges', 'UserChallengeController@index');
Route::get('challenges/{challenge}/join', 'UserChallengeController@join');
Route::post('challenges/{challenge}/join', 'UserChallengeController@storeJoin');
Route::get('challenges/{challenge}', 'UserChallengeController@show');
Route::get('challenges/{challenge}/scoreboard', 'UserChallengeController@scoreboard');
Route::post('challenges/{challenge}/questions/{question}', 'UserChallengeController@submit');


Route::get('hall-of-fame', function () {
    return view('hall-of-fame', ['challenges' => \App\Challenge::all()]);
})->name('hall-of-fame');
