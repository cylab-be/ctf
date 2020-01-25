@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class='text-center'>{{ $challenge->name }}</h1>

    @foreach ($challenge->sets as $set)
    <h2 class='text-center my-4'>{{  $set->name }}</h2>

    @foreach ($set->questions as $question)
    <div class="card">
        <div class='card-header'>
            <h4>{{ $question->name }}</h4>
        </div>
        <div class="card-body">
            {!! $question->statementHTML() !!}
        </div>
        <div class='card-footer'>

        </div>
    </div>
    @endforeach
    @endforeach
</div>
@endsection
