<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Question;
use App\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * The user part of challenges...
 */
class UserChallengeController extends Controller
{

    public function __construct()
    {
        // Uncomment to require authentication
        $this->middleware('auth');
    }

    public function index()
    {
        return view("challenge.index", ["challenges" => Challenge::upcoming()]);
    }

    /**
     * Show the form to join a challenge.
     * @param Challenge $challenge
     */
    public function join(Challenge $challenge)
    {
        // user has already joined...
        if (Auth::user()->belongsToChallenge($challenge)) {
            return redirect(action('UserChallengeController@show', ['challenge' => $challenge]));
        }

        return view('challenge.join', ['challenge' => $challenge]);
    }

    /**
     * Submit the form to join a challenge.
     * @param Challenge $challenge
     * @param Request $request
     */
    public function storeJoin(Challenge $challenge, Request $request)
    {
        if ($request->code === $challenge->code) {
            Auth::user()->challenges()->attach($challenge);
            return redirect(action('UserChallengeController@show', ['challenge' => $challenge]));
        }
    }

    /**
     * Show the questions of a challenge (if started...)
     * @param Challenge $challenge
     * @return type
     */
    public function show(Challenge $challenge)
    {

        $now = time();
        if ($now < $challenge->time_start) {
            return view('challenge.wait', ['challenge' => $challenge]);
        }

        if ($now > $challenge->time_end) {
            return redirect(action('UserChallengeController@scoreboard', ['challenge' => $challenge]));
        }

        return view('challenge.show', ['challenge' => $challenge]);
    }

    public function scoreboard(Challenge $challenge)
    {
        return view('challenge.scoreboard', ['challenge' => $challenge]);
    }

    /**
     * Submit a flag
     * @param Challenge $challenge
     * @param \App\Http\Controllers\Question $question
     */
    public function submit(Challenge $challenge, Question $question, Request $request)
    {
        $now = time();
        if ($now < $challenge->time_start) {
            abort(403);
        }

        if ($now > $challenge->time_end) {
            abort(403);
        }

        $submission = new Submission();
        $submission->user()->associate(Auth::user());
        $submission->question()->associate($question);
        $submission->challenge()->associate($challenge);
        $submission->flag = $request->flag;
        $submission->save();

        if ($request->flag == $question->flag) {
            // send an nice message ;-)
        }

        return redirect(
                action('UserChallengeController@show', ['challenge' => $challenge]) .
                "#q" . $question->id);
    }
}
