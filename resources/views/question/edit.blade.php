@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

                            <div class="col-md-6">
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

                            <div class="col-md-6">
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

                            <div class="col-md-6">
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
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
