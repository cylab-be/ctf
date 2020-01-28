<?php
namespace App\Http\Controllers;

use App\Set;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SetController extends Controller
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
            'name' => 'required|string|regex:/^[a-zA-Z0-9\s-\.]+$/|max:255'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("set.index", array("sets" => Set::all()->sortBy("name")));
    }

    /**
     * Show the form for creating a new resource.
     * We use the same view for create and update => provide an empty Set.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("set.edit", ["set" => new Set()]);
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

        $set = new Set();
        $set->name = $request->name;
        $set->save();
        return redirect(action('SetController@show', ['set' => $set]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Set $set     * @return \Illuminate\Http\Response
     */
    public function show(Set $set)
    {
        return view("set.show", array("set" => $set));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Set $set     * @return \Illuminate\Http\Response
     */
    public function edit(Set $set)
    {
        return view("set.edit", array("set" => $set));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Set $set     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Set $set)
    {
        $this->validator($request->all())->validate();

        $set->name = $request->name;
        $set->save();
        return redirect(action('SetController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Set::find($id)->delete();
        return redirect(action("SetController@index"));
    }
}
