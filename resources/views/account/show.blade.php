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
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Challenge</th>
                            <th>Score</th>
                            <th class="text-right">Position</th>
                        </tr>

                        @foreach($user->registrations as $registration)
                        @php
                        $challenge = $registration->challenge
                        @endphp
                        @if ($challenge !== null)
                        <tr>
                            <td>
                                <a href="{{ action('UserChallengeController@show', ['challenge' => $challenge]) }}">
                                    {{ $challenge->name }}
                                </a>
                                - {{ $challenge->timeEnd()->format('l j F Y') }}
                            </td>
                            <td>{{ $registration->score }}</td>
                            <td class="text-right">
                                @if($registration->position() == 1)
                                <i class="fas fa-medal"></i>
                                @endif
                                {{ $registration->position() }} /
                                {{ $challenge->participants() }}
                            </td>
                        </tr>
                        @endif
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
