@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-header">
                    <h4>
                        {{ $challenge->name }}
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ action("UserChallengeController@storeJoin", ['challenge' => $challenge]) }}">
                        {{ csrf_field() }}

                        <p>This challenge requires an access code...</p>

                        <div class="form-group row">
                            <div class="col-md-6 mx-auto">
                                <input id="code" type="text"
                                       class="text-center form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
                                       name="code"
                                       value="{{ old('code') }}" required autofocus>

                                @if ($errors->has('code'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 mx-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Join
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
