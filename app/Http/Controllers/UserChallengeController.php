<?php

namespace App\Http\Controllers;

use App\Challenge;
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
        return view('challenge.show', ['challenge' => $challenge]);
    }

    public function scoreboard(Challenge $challenge)
    {
        return view('challenge.scoreboard', ['challenge' => $challenge]);
    }
}
