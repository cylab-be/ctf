@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card my-3">
                <div class="card-header">{{ $set->name }}</div>

                <div class="card-body">
                    <p>Name: {{ $set->name }}</p>

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
        </div>

        <div class="col-lg-8">
            <div class="card my-3">
                <div class="card-header">
                    Questions
                </div>

                <div class="card-body">
                    <p>
                        <a href="{{ action('QuestionController@create', ['set' => $set]) }}"
                           class="btn btn-primary"
                           id="add">
                            <i class="fas fa-plus-circle"></i> <u>A</u>dd a question
                        </a>
                    </p>

                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        @foreach($set->questions as $question)
                        <tr>
                            <td>#{{ $loop->iteration }}</td>
                            <td>{{ $question->name }}</td>
                            <td class="text-right">
                                <a class="btn btn-primary btn-sm"
                                   href="{{ action('QuestionController@show', ['set' => $set, 'question' => $question]) }}">
                                    <i class="fas fa-search"></i> Show
                                </a>

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
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
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
