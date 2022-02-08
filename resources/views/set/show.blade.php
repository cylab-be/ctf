@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card my-3">
                <div class="card-header">{{ $set->name }}</div>

                <div class="card-body">
                    <p>
                        <span class='text-muted'>created by</span>
                        {{ $set->user->name }}<br>
                        <span class='text-muted'>on</span>
                        {{ $set->created_at }}
                    </p>

                    <div>
                        <a class="btn btn-primary"
                           href="{{ action('SetController@edit', ['set' => $set]) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form method="POST"
                              action="{{ action('SetController@destroy', ['set' => $set]) }}"
                              style="display: inline-block">
                            {{ csrf_field() }}
                            {{ method_field("DELETE") }}
                            <button class="btn btn-danger">
                                <i class="fas fa-times-circle"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card my-3">
                <div class="card-header">Used in following challenges...</div>

                <div class="card-body">
                    <ul class="list-unstyled">
                    @foreach ($set->challenges as $challenge)
                        <li>
                            <a href="{{ action('ChallengeController@show', ['challenge' => $challenge]) }}">
                            {{ $challenge->name }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h3>{{ $set->name }}</h3>

            @if ($set->description)
            <div class='card mb-4'>
                <div class='card-body'>
                    {!! $set->descriptionHTML() !!}
                </div>
            </div>
            @endif

            <p>
                <a href="{{ action('QuestionController@create', ['set' => $set]) }}"
                   class="btn btn-primary"
                   id="add">
                    <i class="fas fa-plus-circle"></i> <u>A</u>dd a question
                </a>
            </p>

            @foreach($set->questions as $question)
            <div class="card mb-4" id='q{{ $question->id }}'>
                <div class='card-header'>
                    <h4>#{{ $loop->iteration }}  {{ $question->name }}</h4>
                </div>

                <div class="card-body">
                    {!! $question->statementHTML() !!}

                    <p>Flag: {{ $question->flag }}</p>
                    <p>Allowed submissions: {{ $question->max_submissions }}</p>
                </div>

                <div class='card-footer'>
                    <a class="btn btn-primary btn-sm"
                       href="{{ action('QuestionController@edit', ['set' => $set, 'question' => $question]) }}">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form method="POST"
                          action="{{ action('QuestionController@destroy', ['set' => $set, 'question' => $question]) }}"
                          style="display: inline-block">
                        {{ csrf_field() }}
                        {{ method_field("DELETE") }}
                        <button class="btn btn-danger btn-sm">
                            <i class="fas fa-times-circle"></i> Delete
                        </button>
                    </form>

                    <form method="POST"
                          class="form-inline"
                          action="{{ action('QuestionController@move', ['set' => $set, 'question' => $question]) }}"
                          style="display: inline-block">
                        {{ csrf_field() }}
                        <button class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-circle-right"></i> Move to
                        </button>

                        <select class="form-control form-control-sm" name="set_id" id="set_id">
                            @foreach(\App\Set::all()->sortBy('name') as $set)
                            <option value="{{ $set->id }}">
                                {{ $set->name }}
                                ({{ $set->questions()->count() }} questions)
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function(){
    shortcut.add("Ctrl+A",function() {
        console.log("Add...");
        document.getElementById("add").click()
    });
});
</script>
@endsection
