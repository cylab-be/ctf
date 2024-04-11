@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class='text-center'>{{ $challenge->name }}</h1>

    @if (count($challenge->sets) > 1)
    <div class='text-center my-4'>
       @foreach ($challenge->sets as $set)
       <a class='btn btn-sm btn-primary my-1' href='#s{{ $set->id }}'>{{ $set->name }}</a>
       @endforeach
    </div>
    @endif

    @foreach ($challenge->sets as $set)
    <h2 class='text-center my-5' id='s{{ $set->id }}'>{{ $set->name }}</h2>

    @if ($set->description)
    <div class='card mb-4'>
        <div class='card-body'>
            {!! $set->descriptionHTML() !!}
        </div>
    </div>
    @endif

    @foreach ($set->questions as $question)
    <div class="card mb-4 {{ $question->isSolvedFor($challenge) ? 'border-success' : '' }}"
         id='q{{ $question->id }}'>
        <div class='card-body'>
            @include("question.partials.show", ["question" => $question])
        </div>
        <div class='card-footer'>
            @if ($question->isAvailableFor($challenge))
            <form method="POST"
                  class="form-inline"
                  action="{{ action('UserChallengeController@submit', ['challenge' => $challenge, 'question' => $question]) }}"
                  style="display: inline-block">
                {{ csrf_field() }}

                <input type="text" class='form-control' name='flag'
                       autocomplete="off" placeholder="Flag">

                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-check"></i> Submit
                </button>
            </form>
            @endif

            <b>{{ $question->remainingSubmissionsFor($challenge) }}</b> remaining submissions...
        </div>
    </div>
    @endforeach
    @endforeach
</div>

<div class="footer fixed-bottom bg-white shadow-sm-top" style='padding: 0.5rem 1rem;'>
    <div class='container'>
        Current score : <b>{{ $registration->score }}</b> |
        Position : <b>{{ $registration->position() }} / {{ $challenge->participants() }}</b> |
        Time left : <b><span class="timer" data-seconds-left={{ $challenge->timeEndDiffSeconds() }}></span></b>
    </div>
</div>
@endsection
