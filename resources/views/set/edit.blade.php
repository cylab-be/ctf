@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Set</div>

                <div class="card-body">
                    @if (!$set->exists)
                    <form method="POST" action="{{ action("SetController@store") }}">
                    @else
                    <form method="POST"
                          action="{{ action("SetController@update", ["set" => $set]) }}">
                    {{ method_field("PUT") }}
                    @endif
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">Name</label>

                            <div class="col-md-9">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name"
                                       value="{{ old('name', $set->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label text-md-right">Description</label>

                            <div class="col-md-9">
                                <textarea id="description" type="text"
                                          rows='10'
                                          placeholder="You can use markdown here..."
                                          class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                          name="description">{{ old('description', $set->description) }}</textarea>

                                <span class='text-muted'>
                                    This description is visible for the participants.
                                </span>

                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
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
