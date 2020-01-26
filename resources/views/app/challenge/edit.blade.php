@extends('layouts.app')

@section('content')
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css">
<script src="/js/jquery.datetimepicker.full.min.js" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        console.log('scripts loaded...');
        jQuery('#time_start').datetimepicker();
        jQuery('#time_end').datetimepicker();
    });
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Challenge</div>

                <div class="card-body">
                    @if (!$challenge->exists)
                    <form method="POST" action="{{ action("ChallengeController@store") }}">
                    @else
                    <form method="POST"
                          action="{{ action("ChallengeController@update", ["challenge" => $challenge]) }}">
                    {{ method_field("PUT") }}
                    @endif
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name"
                                       value="{{ old('name', $challenge->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time_start" class="col-md-4 col-form-label text-md-right">Start time:</label>

                            <div class="col-md-6">
                                <input id="time_start" type="text"
                                       class="form-control{{ $errors->has('time_start') ? ' is-invalid' : '' }}"
                                       name="time_start"
                                       value="{{ old('time_start', $challenge->timeStartForHumans()) }}" required>

                                @if ($errors->has('time_start'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('time_start') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time_end" class="col-md-4 col-form-label text-md-right">End time</label>

                            <div class="col-md-6">
                                <input id="time_end" type="text"
                                       class="form-control{{ $errors->has('time_end') ? ' is-invalid' : '' }}"
                                       name="time_end"
                                       value="{{ old('time_end', $challenge->timeEndForHumans()) }}" required>

                                @if ($errors->has('time_end'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('time_end') }}</strong>
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
