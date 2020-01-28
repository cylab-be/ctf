@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1 class='mt-5 text-center font-weight-bold'>Capture the Flag</h1>
    <div class="text-muted text-center mb-5">
        powered by <a href='https:/cylab.be'>https://cylab.be</a>
    </div>

    <div class='grid'>
        <div class="grid-sizer col-md-6"></div>

        @foreach($challenges as $challenge)
        <div class="grid-item col-md-6 my-4">
            <div class="card grid-item-content">
                <div class="card-body">
                    <h4 class="card-title">
                        {{ $challenge->name }}
                    </h4>

                    <p>Start : {{ $challenge->timeStart()->diffForHumans() }}</p>

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
