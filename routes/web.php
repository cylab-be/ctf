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

$app_url = config("app.url");
if (!empty($app_url)) {
    URL::forceRootUrl($app_url);
    $schema = explode(':', $app_url)[0];
    URL::forceScheme($schema);
}

Route::get('/', function () {
    return redirect(route('challenges'));
});

Auth::routes();

// challenges management
Route::resource('app/challenges', 'ChallengeController');
Route::get('app/challenges/{challenge}/access', 'ChallengeController@access');
Route::get('app/challenges/{challenge}/start', 'ChallengeController@start');
Route::get('app/challenges/{challenge}/stop', 'ChallengeController@stop');
Route::get('app/challenges/{challenge}/statistics', 'ChallengeController@statistics');
Route::get('app/challenges/{challenge}/solution', 'ChallengeController@solution');
Route::post('app/challenges/{challenge}/set/add', 'ChallengeController@addSet');
Route::delete('app/challenges/{challenge}/set/{set}', 'ChallengeController@removeSet');
Route::get('app/challenges/{challenge}/notify-completed', 'ChallengeController@notifyCompleted');


// questions management
Route::resource('app/sets', 'SetController');
Route::resource('app/sets.questions', 'QuestionController');
Route::post('app/sets/{set}/questions/{question}/move', 'QuestionController@move');
Route::post('app/sets/{set}/questions/{question}/upload', 'QuestionController@uploadFile');
Route::delete('app/sets/{set}/questions/{question}/files/{file}', 'QuestionController@destroyFile');
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
Route::get('challenges/{challenge}/set/{set}', 'UserChallengeController@showSet');
Route::post('challenges/{challenge}/questions/{question}', 'UserChallengeController@submit');


Route::get('hall-of-fame', function () {
    return view('hall-of-fame', ['challenges' => \App\Challenge::finished()]);
})->name('hall-of-fame');


Route::get('profile', 'AccountController@show');
Route::get('profile/edit', 'AccountController@edit');
Route::put('profile', 'AccountController@update');
Route::put('profile/password', 'AccountController@updatePassword');

Route::get(
    'registration/{registration}/certificate',
    function (App\Registration $registration) {

        if (!$registration->challenge->isFinished()) {
            abort(403);
        }

        return $registration->certificate()->stream();
    }
)->name('certificate');


Route::get('help', function () {
    return view('help');
})->name('help');
