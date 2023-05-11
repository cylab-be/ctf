<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function __construct()
    {
        // Uncomment to require authentication
        $this->middleware('auth');
    }

    public function show()
    {
        return view('account.show', ['user' => Auth::user()]);
    }

    protected function validator(array $data)
    {
        $user = Auth::user();

        return Validator::make($data, [
            'name' => 'required|string|max:40',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ]]);
    }

    public function edit()
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $request->session()->flash('info', 'Profile updated!');

        return redirect(action('AccountController@show'));
    }

    protected function passwordValidator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|confirmed|min:8',
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail($attribute . ' is invalid.');
                    }
                },
            ]
        ]);
    }

    /**
     * Update the password
     * @param Request $request
     */
    public function updatePassword(Request $request)
    {
        $this->passwordValidator($request->all())->validate();

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        $request->session()->flash('info', 'Password updated!');

        return redirect(action('AccountController@show'));
    }
}
