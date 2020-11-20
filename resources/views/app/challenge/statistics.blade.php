@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Statistics</h1>

    <p>Name: {{ $challenge->name }}</p>
    <p>Start: {{ $challenge->timeStartForHumans()  }}</p>


    @foreach ($challenge->sets as $set)
    <h5>{{ $set->name }}</h5>
    <table class='table'>
        <tr>
            <th>Question</th>
            <th class='text-right'>Answered correctly by</th>
        </tr>

        @foreach ($set->questions as $question)
        <tr>
            <td>
                <a href='{{ action('SetController@show', ['set' => $question->set]) }}#q{{ $question->id }}'>
                #{{ $loop->iteration }}  {{ $question->name }}
                </a>
            </td>
            <td class='text-right'>
                {{ $challenge->submissionStatistics()[$question->id] ?? 0 }}
            </td>
        </tr>
        @endforeach
    </table>
    @endforeach
</div>