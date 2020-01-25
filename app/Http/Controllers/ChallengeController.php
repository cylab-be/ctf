<?php
namespace App\Http\Controllers;

use App\Challenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{

    public function __construct()
    {
        // Uncomment to require authentication
        // $this->middleware('auth');
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
            'name' => 'required|string|regex:/^[a-zA-Z0-9\s-\.]+$/|max:255',
            'time_start' => 'required|integer',
            'time_end' => 'required|integer'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("challenge.index", array("challenges" => Challenge::all()->sortBy("name")));
    }

    /**
     * Show the form for creating a new resource.
     * We use the same view for create and update => provide an empty Challenge.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("challenge.edit", ["challenge" => new Challenge()]);
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
        $challenge->time_start = $request->time_start;
        $challenge->time_end = $request->time_end;
        $challenge->save();
        return redirect(action('ChallengeController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Challenge $challenge     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        return view("challenge.show", array("challenge" => $challenge));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Challenge $challenge     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        return view("challenge.edit", array("challenge" => $challenge));
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
}
