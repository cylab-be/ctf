<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Question;
use App\Submission;
use App\Registration;
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
        $registration = Registration::find($challenge, Auth::user());
        // user has already joined...
        if ($registration != null) {
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
            $registration = new Registration();
            $registration->challenge_id = $challenge->id;
            $registration->user_id = Auth::user()->id;
            $registration->save();

            return redirect(action('UserChallengeController@show', ['challenge' => $challenge]));
        }

        return redirect(action('UserChallengeController@join', ['challenge' => $challenge]));
    }

    /**
     * Show the questions of a challenge (if started...)
     * @param Challenge $challenge
     * @return type
     */
    public function show(Challenge $challenge)
    {
        $registration = Registration::find($challenge, Auth::user());

        if ($registration == null) {
            return redirect(action('UserChallengeController@join', ['challenge' => $challenge]));
        }

        if (time() < $challenge->time_start) {
            return view('challenge.wait', ['challenge' => $challenge]);
        }

        if (time() > $challenge->time_end) {
            return redirect(action('UserChallengeController@scoreboard', ['challenge' => $challenge]));
        }

        return view('challenge.show', [
            'challenge' => $challenge,
            'registration' => $registration]);
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
        $registration = Registration::find($challenge, Auth::user());

        if ($registration == null) {
            return redirect(action('UserChallengeController@join', ['challenge' => $challenge]));
        }

        if (time() < $challenge->time_start) {
            abort(403);
        }

        if (time() > $challenge->time_end) {
            abort(403);
        }

        if ($request->flag == null) {
            // nothing submitted...
            return redirect(
                action('UserChallengeController@show', ['challenge' => $challenge]) .
                    "#q" . $question->id
            );
        }

        $submission = new Submission();
        $submission->registration()->associate($registration);
        $submission->question()->associate($question);
        $submission->flag = $request->flag;
        $submission->save();

        if ($question->verify($request->flag)) {
            // send an nice message ;-)

            $registration->score = $registration->score + 1;
            $registration->save();
        }

        return redirect(
            action('UserChallengeController@show', ['challenge' => $challenge]) .
            "#q" . $question->id
        );
    }
}
