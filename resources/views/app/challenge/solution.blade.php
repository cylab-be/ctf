@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="text-center">{{ $challenge->name }}</h1>
    <p class="text-center">{{ $challenge->timeStartForHumans()  }}</p>


    @foreach ($challenge->sets as $set)
    <h3 class="text-center">{{ $set->name }}</h3>

        @foreach ($set->questions as $question)
        <div class="card mb-4" id='q{{ $question->id }}'>
                <div class='card-header'>
                    <h4>#{{ $loop->iteration }}  {{ $question->name }}</h4>
                </div>

                <div class="card-body">
                    {!! $question->statementHTML() !!}
                </div>

                <div class='card-footer'>
                    Solution: {{ $question->flag }}
                </div>
            </div>
        @endforeach
    @endforeach
</div>
@endsection
