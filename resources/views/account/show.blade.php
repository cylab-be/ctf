@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <div class="card my-3">
                <div class="card-header">
                    {{ $user->name }}
                </div>

                <div class="card-body">
                    <p>Name: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Password: *****</p>

                    <p>
                        <a class="btn btn-primary"
                           href='{{ action('AccountController@edit')  }}'>
                            <i class="fas fa-edit"></i> Modify
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card my-3">
                <div class="card-header">
                    My challenges
                </div>

                <div class="card-body">
                    <table class="table">
                        @foreach($user->registrations as $registration)
                        <tr>
                            <td>
                                <a href="{{ action('UserChallengeController@show', ['challenge' => $registration->challenge]) }}">
                                    {{ $registration->challenge->name }}
                                </a>
                            </td>
                            <td>{{ $registration->score }}</td>
                        </tr>
                        @endforeach
                    </table>

                    <p>
                        <a class="btn btn-primary" href="{{ route('challenges') }}">
                            <i class="fas fa-sign-in-alt"></i> Join another challenge
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
