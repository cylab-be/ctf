@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1>Challenges</h1>
    <p>
        <a href="{{ action('ChallengeController@create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New
        </a>
    </p>

    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th></th>
        </tr>
        @foreach($challenges as $challenge)
        <tr>
            <td>{{ $challenge->name }}</td>
            <td class="text-right">
                <a class="btn btn-primary btn-sm"
                   href="{{ action('ChallengeController@show', ['challenge' => $challenge]) }}">
                    <i class="fas fa-search"></i> Show
                </a>

                <a class="btn btn-primary btn-sm"
                   href="{{ action('ChallengeController@edit', ['challenge' => $challenge]) }}">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form method="POST"
                      action="{{ action('ChallengeController@destroy', ['challenge' => $challenge]) }}"
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
@endsection
