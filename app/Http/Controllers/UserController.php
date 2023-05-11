<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
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
            'name' => 'required|string|regex:/^[a-zA-Z0-9\s\-\.]+$/|max:255'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view("user.index", array("users" => User::all()->sortBy("name")));
    }

    /**
     * Show the form for creating a new resource.
     * We use the same view for create and update => provide an empty User.
     *
     */
    public function create()
    {
        return view("user.edit", ["user" => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = new User();
        $user->name = $request->name;
        $user->save();
        return redirect(action('UserController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     */
    public function show(User $user)
    {
        return view("user.show", array("user" => $user));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     */
    public function edit(User $user)
    {
        return view("user.edit", array("user" => $user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     */
    public function update(Request $request, User $user)
    {
        $this->validator($request->all())->validate();

        $user->name = $request->name;
        $user->save();
        return redirect(action('UserController@index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        if ($id == Auth::user()->id) {
            // you cannot destroy yourself!
            return redirect(action("UserController@index"));
        }

        User::find($id)->delete();
        return redirect(action("UserController@index"));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->isAdmin()) {
            $user->admin = false;
        } else {
            $user->admin = true;
        }

        $user->save();
        return redirect(action('UserController@index'));
    }
}
