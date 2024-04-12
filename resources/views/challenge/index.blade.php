@extends('layouts.app')

@section('title', 'Challenges')
@section('body-class', 'bg-cyber')

@section('content')
<div class="container">
    <h1 class='my-5 text-center text-white martian-mono-400'>
        Capture the <b>Flag</b>
    </h1>

    @foreach($challenges as $challenge)
    <div class="card mb-3 bg-white-80">
        <div class="card-body">
            <h4 class="card-title">
                {{ $challenge->name }}
            </h4>

            <p>Start : {{ $challenge->timeStart()->diffForHumans() }}</p>

            <a class='btn btn-primary'
               href='{{ route('scoreboard', ['challenge' => $challenge]) }}'>
                <i class="fas fa-chess"></i> Scoreboard
            </a>

            <a class="btn btn-primary"
               href="{{ action('UserChallengeController@join', ['challenge' => $challenge]) }}">
                <i class="fas fa-sign-in-alt"></i> Join
            </a>
        </div>

        <div class="card-footer text-muted">
            {{ $challenge->status() }}
        </div>
    </div>
    @endforeach
</div>
@endsection
