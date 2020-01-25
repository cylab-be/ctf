@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class='text-center'>{{ $challenge->name }}</h1>

    @foreach ($challenge->sets as $set)
    <h2 class='text-center my-4'>{{  $set->name }}</h2>

    @foreach ($set->questions as $question)
    <div class="card mb-3 {{ $question->isSolvedFor($challenge) ? 'border-success' : '' }}">
        <div class='card-header'>
            <h4>{{ $question->name }}</h4>
        </div>
        <div class="card-body">
            {!! $question->statementHTML() !!}
        </div>
        <div class='card-footer'>
            @if (!$question->isSolvedFor($challenge))
            <form method="POST"
                  class="form-inline"
                  action="{{ action('UserChallengeController@submit', ['challenge' => $challenge, 'question' => $question]) }}"
                  style="display: inline-block">
                {{ csrf_field() }}

                <input type="text" class='form-control' name='flag'>

                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-check"></i> Submit
                </button>
            </form>
            @endif

        </div>
    </div>
    @endforeach
    @endforeach
</div>
@endsection
