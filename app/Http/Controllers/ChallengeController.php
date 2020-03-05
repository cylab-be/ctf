<?php
namespace App\Http\Controllers;

use App\Challenge;
use App\Set;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'time_start' => 'required|date',
            'time_end' => 'required|date'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("app.challenge.index", array("challenges" => Challenge::all()->sortBy("name")));
    }

    /**
     * Show the form for creating a new resource.
     * We use the same view for create and update => provide an empty Challenge.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("app.challenge.edit", ["challenge" => new Challenge()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $challenge = new Challenge();
        $challenge->name = $request->name;
        $challenge->code = Str::random(6);
        $challenge->time_start = Carbon::createFromFormat("Y/m/d H:i", $request->time_start)->getTimestamp();
        $challenge->time_end = Carbon::createFromFormat("Y/m/d H:i", $request->time_end)->getTimestamp();
        $challenge->save();

        return redirect(action('ChallengeController@show', ['challenge' => $challenge]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Challenge $challenge     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        return view("app.challenge.show", array("challenge" => $challenge));
    }

    /**
     * Show access code for this challenge
     * @param Challenge $challenge
     * @return type
     */
    public function access(Challenge $challenge)
    {
        return view("app.challenge.access", array("challenge" => $challenge));
    }

    public function start(Challenge $challenge)
    {
        $challenge->time_start = time();
        $challenge->save();
        return redirect(action('ChallengeController@show', ["challenge" => $challenge]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Challenge $challenge     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        return view("app.challenge.edit", array("challenge" => $challenge));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Challenge $challenge     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge)
    {
        $this->validator($request->all())->validate();

        $challenge->name = $request->name;
        $challenge->time_start = Carbon::createFromFormat("Y/m/d H:i", $request->time_start)->getTimestamp();
        $challenge->time_end = Carbon::createFromFormat("Y/m/d H:i", $request->time_end)->getTimestamp();
        $challenge->save();
        return redirect(action('ChallengeController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Challenge::find($id)->delete();
        return redirect(action("ChallengeController@index"));
    }

    public function addSet(Challenge $challenge, Request $request)
    {
        $set_id = $request->set_id;
        $challenge->sets()->attach($set_id);
        return redirect(action('ChallengeController@show', ['challenge' => $challenge]));
    }

    public function removeSet(Challenge $challenge, Set $set)
    {
        $challenge->sets()->detach([$set->id]);
        return redirect(action('ChallengeController@show', ['challenge' => $challenge]));
    }
}
