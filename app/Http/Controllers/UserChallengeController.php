<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Question;
use App\Submission;
use App\Registration;
use App\Set;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * The user part of challenges...
 * UserChallengeController@show is the main action.
 *
 */
class UserChallengeController extends Controller
{

    public function __construct()
    {
        // Uncomment to require authentication
        $this->middleware('auth');
    }

    /**
     * Show the form to join a challenge.
     * @param Challenge $challenge
     */
    public function join(Challenge $challenge)
    {
        // user has already joined...
        $registration = Registration::find($challenge, Auth::user());
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
        // user has already joined...
        $registration = Registration::find($challenge, Auth::user());
        if ($registration != null) {
            return redirect(action('UserChallengeController@show', ['challenge' => $challenge]));
        }

        if ($request->code === $challenge->code) {
            $registration = new Registration();
            $registration->challenge_id = $challenge->id;
            $registration->user_id = Auth::user()->id;
            $registration->save();
        }

        return redirect(action('UserChallengeController@show', ['challenge' => $challenge]));
    }

    /**
     * Show the questions of a challenge (if started...)
     * @param Challenge $challenge
     */
    public function show(Challenge $challenge)
    {
        
        $registration = Registration::find($challenge, Auth::user());
        
        // not registered yet
        if ($registration == null) {
            return redirect(action('UserChallengeController@join', ['challenge' => $challenge]));
        }

        if (time() < $challenge->time_start) {
            return view('challenge.wait', ['challenge' => $challenge]);
        }

        if (time() > $challenge->time_end) {
            return redirect(route('scoreboard', ['challenge' => $challenge]));
        }
        
        $set = $challenge->sets->first();
        
        return redirect(action("UserChallengeController@showSet", ["challenge" => $challenge, "set" => $set]));
    }
    
    public function showSet(Challenge $challenge, Set $set)
    {
        $registration = Registration::find($challenge, Auth::user());
        
        // not registered yet
        if ($registration == null) {
            return redirect(action('UserChallengeController@join', ['challenge' => $challenge]));
        }

        if (time() < $challenge->time_start) {
            return view('challenge.wait', ['challenge' => $challenge]);
        }

        if (time() > $challenge->time_end) {
            return redirect(route('scoreboard', ['challenge' => $challenge]));
        }
        
        if (! $challenge->sets->contains($set)) {
            abort(404);
        }
        
        return view('challenge.show', [
            'challenge' => $challenge,
            'registration' => $registration,
            "set" => $set]);
    }

    /**
     * Submit a flag
     * @param Challenge $challenge
     * @param Question $question
     */
    public function submit(Challenge $challenge, Question $question, Request $request)
    {
        $registration = Registration::find($challenge, Auth::user());
        if ($registration == null) {
            return redirect(action('UserChallengeController@show', ['challenge' => $challenge]));
        }

        if (time() < $challenge->time_start) {
            abort(403);
        }

        if (time() > $challenge->time_end) {
            toastr()->error("Time is up!");
            return redirect(action('UserChallengeController@show', ['challenge' => $challenge]));
        }
        
        $set = $question->set;

        if ($request->flag == null) {
            toastr()->error("Looks like you submitted an empty flag!");
            return redirect(action("UserChallengeController@showSet", ["challenge" => $challenge, "set" => $set]));
        }

        if (!$question->isAvailableFor($registration->challenge)) {
            // too many submissions or already sent the correct answer
            return redirect(action("UserChallengeController@showSet", ["challenge" => $challenge, "set" => $set]));
        }

        $submission = new Submission();
        $submission->registration()->associate($registration);
        $submission->question()->associate($question);
        $submission->flag = $request->flag;
        $submission->save();

        if ($submission->isCorrect()) {
            toastr()->success("<b>Correct</b> answer for " . $question->name . " !");

            $registration->score = $registration->score + $question->points;
            $registration->save();
        } else {
            toastr()->error("<b>Wrong</b> answer for " . $question->name . " !");
        }

        return redirect(action("UserChallengeController@showSet", ["challenge" => $challenge, "set" => $set]));
    }
}
