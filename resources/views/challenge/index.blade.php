@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1 class='my-5 text-center'>Challenges</h1>

    <div class='grid'>
        <div class="grid-sizer col-md-4"></div>

        @foreach($challenges as $challenge)
        <div class="grid-item col-md-4 my-4">
            <div class="card grid-item-content">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $challenge->name }}
                    </h5>

                    <p>Start {{ $challenge->timeStart()->diffForHumans() }}</p>

                    <a class='btn btn-primary'
                       href='{{ action('UserChallengeController@scoreboard', ['challenge' => $challenge]) }}'>
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
        </div>
        @endforeach
    </div>

</div>
@endsection
