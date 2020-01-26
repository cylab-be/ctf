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

                    <div>
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
                                {{ $set->name }}
                                ({{ $set->questions()->count() }} questions)
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
                            <option value="{{ $set->id }}">{{ $set->name }}</option>
                            @endforeach
                        </select>

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-plus-circle"></i> Add
                        </button>
                    </form>
                    or <a href="{{ action('SetController@create') }}">create a new question set</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
