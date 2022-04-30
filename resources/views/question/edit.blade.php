@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Question</div>

        <div class="card-body">
            @if (!$question->exists)
            <form method="POST" action="{{ action("QuestionController@store", ['set' => $question->set]) }}">
            @else
            <form method="POST"
                  action="{{ action("QuestionController@update", ['set' => $question->set, "question" => $question]) }}">
            {{ method_field("PUT") }}
            @endif
                {{ csrf_field() }}

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                    <div class="col-md-8">
                        <input id="name" type="text"
                               class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               name="name"
                               value="{{ old('name', $question->name) }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="statement" class="col-md-4 col-form-label text-md-right">Statement</label>

                    <div class="col-md-8">
                        <textarea id="statement"
                               class="form-control{{ $errors->has('statement') ? ' is-invalid' : '' }}"
                               name="statement" rows="10"
                               required>{{ old('statement', $question->statement) }}</textarea>

                        @if ($errors->has('statement'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('statement') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="flag" class="col-md-4 col-form-label text-md-right">Flag</label>

                    <div class="col-md-8">
                        <input id="flag" type="text"
                               class="form-control{{ $errors->has('flag') ? ' is-invalid' : '' }}"
                               name="flag"
                               value="{{ old('flag', $question->flag) }}" required>

                        @if ($errors->has('flag'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('flag') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="max_submissions" class="col-md-4 col-form-label text-md-right">Allowed submissions</label>

                    <div class="col-md-8">
                        <input id="max_submissions" type="integer"
                               class="form-control{{ $errors->has('max_submissions') ? ' is-invalid' : '' }}"
                               name="max_submissions"
                               value="{{ old('max_submissions', $question->max_submissions) }}" required>

                        @if ($errors->has('max_submissions'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('max_submissions') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" id="save" class="btn btn-primary">
                            <i class="fas fa-check"></i> <u>S</u>ave
                        </button>

                        <button type="submit" id="save-add" name="save-add" value="1"
                                class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Save and <u>a</u>dd a new question
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function(){
    shortcut.add("Ctrl+S",function() {
        console.log("Saving...");
        $("#save").click();
    });

    shortcut.add("Ctrl+A",function() {
        console.log("Saving...");
        $("#save-add").click();
    });
});
</script>
@endsection
