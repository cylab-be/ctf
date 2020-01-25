@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $question->name }}</div>

                <div class="card-body">
                    <p>
                        Question set:
                        <a href="{{ action('SetController@show', ['set' => $question->set]) }}">
                            {{ $question->set->name }}
                        </a>
                    </p>

                    <p>Flag: {{ $question->flag  }}</p>

                    <div>{!! $question->statementHTML() !!}</div>

                    <div>
                        <a class="btn btn-primary"
                           href="{{ action('QuestionController@edit', ['set' => $question->set, 'question' => $question]) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form method="POST"
                              action="{{ action('QuestionController@destroy', ['set' => $question->set, 'question' => $question]) }}"
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
        </div>
    </div>
</div>
@endsection
