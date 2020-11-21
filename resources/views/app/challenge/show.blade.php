@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ $challenge->name }}</div>

                <div class="card-body">
                    <p>Name: {{ $challenge->name }}</p>
                    <p>Access code: {{ $challenge->code }}</p>
                    <p>Start: {{ $challenge->timeStartForHumans()  }}</p>
                    <p>End: {{ $challenge->timeEndForHumans()  }}</p>

                    <div class="mb-3">
                        <a class="btn btn-primary"
                           href="{{ action('ChallengeController@start', ['challenge' => $challenge]) }}">
                            <i class="fas fa-play"></i> Start NOW
                        </a>

                        <a class="btn btn-primary"
                           href="{{ action('ChallengeController@edit', ['challenge' => $challenge]) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form method="POST"
                              action="{{ action('ChallengeController@destroy', ['challenge' => $challenge]) }}"
                              style="display: inline-block">
                            {{ csrf_field() }}
                            {{ method_field("DELETE") }}
                            <button class="btn btn-danger">
                                <i class="fas fa-times-circle"></i> Delete
                            </button>
                        </form>
                    </div>

                    <div>
                        <a href="{{ action('ChallengeController@access', ['challenge' => $challenge]) }}"
                            class="btn btn-primary">
                               <i class="fas fa-eye"></i> Show access code
                        </a>

                        <a class='btn btn-primary my-2'
                           href='{{ route('scoreboard', ['challenge' => $challenge]) }}'>
                            <i class="fas fa-chess"></i> Scoreboard
                        </a>

                        <a class='btn btn-primary my-2'
                           href='{{ action('ChallengeController@statistics', ['challenge' => $challenge]) }}'>
                            <i class="fas fa-list-ol"></i> Stats
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    Question sets
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        @foreach($challenge->sets as $set)
                        <tr>
                            <td>
                                <a href="{{ action('SetController@show', ['set' => $set]) }}">
                                {{ $set->name }}
                                </a>
                                <span class='text-muted'>{{ $set->questions()->count() }} questions</span>
                            </td>
                            <td class="text-right">
                                <form method="POST"
                                      action="{{ action('ChallengeController@removeSet', ['challenge' => $challenge, 'set' => $set]) }}"
                                      style="display: inline-block">
                                    {{ csrf_field() }}
                                    {{ method_field("DELETE") }}
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-times-circle"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <form method="POST"
                          class="form-inline"
                          action="{{ action('ChallengeController@addSet', ['challenge' => $challenge]) }}"
                          style="display: inline-block">
                        {{ csrf_field() }}

                        <select name="set_id" id="set_id" class="form-control">
                            @foreach($challenge->setsAttachable() as $set)
                            <option value="{{ $set->id }}">
                                {{ $set->name }}
                                ({{ $set->questions()->count() }} questions)
                            </option>
                            @endforeach
                        </select>

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-plus-circle"></i> Add
                        </button>
                    </form>
                    or <a href="{{ action('SetController@create') }}">create a new question set</a>

                </div>
            </div>

            <div class='card my-3'>
                <div class='card-header'>
                    Latest submissions
                </div>
                <div class='card-body'>
                    <table class='table'>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Question</th>
                            <th>Flag</th>
                        </tr>

                        @foreach ($challenge->latestSubmissions() as $submission)
                        <tr>
                            <td>{{ $submission->created_at }}</td>
                            <td>{{ $submission->registration->user->name }}</td>
                            <td>
                                @if ($submission->question === null)
                                -- DELETED --
                                @else
                                <a href='{{ action('SetController@show', ['set' => $submission->question->set]) }}#q{{ $submission->question->id }}'>
                                {{ $submission->question->name }}
                                </a>
                                @endif
                            </td>
                            <td>
                                {{ $submission->flag }}
                                @if ($submission->question === null)
                                <i class="fas fa-question-circle text-warning"></i>
                                @elseif ($submission->isCorrect())
                                <i class="fas fa-check-circle text-success"></i>
                                @else
                                <i class="fas fa-times-circle text-danger"></i>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
