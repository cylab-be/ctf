@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1>Challenges</h1>

    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th>Start</th>
            <th></th>
        </tr>
        @foreach($challenges as $challenge)
        <tr>
            <td>{{ $challenge->name }}</td>
            <td>{{ $challenge->timeStart()->diffForHumans() }}</td>

            <td class="text-right">
                <a class='btn btn-primary'
                   href='{{ action('UserChallengeController@scoreboard', ['challenge' => $challenge]) }}'>
                       <i class="fas fa-chess"></i> Scoreboard
                </a>

                <a class="btn btn-primary"
                   href="{{ action('UserChallengeController@join', ['challenge' => $challenge]) }}">
                    <i class="fas fa-sign-in-alt"></i> Join
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
