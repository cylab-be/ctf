@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-5 sticky-top">
                <div class="card-body">
                    <h1 >{{ $challenge->name }}</h1>
                    <ul class="list-unstyled">
                        @foreach ($challenge->sets as $s)
                        <li>
                            <a class="text-decoration-none" 
                               href='{{ action("UserChallengeController@showSet", ["challenge" => $challenge, "set" => $s]) }}'>
                                {{ $s->name }} [{{ $s->maxScore() }} points]
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <p>
                        <a href="{{ route("scoreboard", ["challenge" => $challenge]) }}"
                           class="text-decoration-none">
                            Scoreboard
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-5">
                <div class="card-body">
                    @include("challenge.partials.set")
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer fixed-bottom bg-white shadow-sm-top" style='padding: 0.5rem 1rem;'>
    <div class='container'>
        Current score : <b>{{ $registration->score }}</b> |
        Position : <b>{{ $registration->position() }} / {{ $challenge->participants() }}</b> |
        Time left : <b><span class="timer" data-seconds-left={{ $challenge->timeEndDiffSeconds() }}></span></b>
    </div>
</div>
@endsection
