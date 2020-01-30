@extends('layouts.app')

@section('title', 'Sets')

@section('content')
<div class="container">
    <h1>Question sets</h1>
    <p>
        <a href="{{ action('SetController@create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New
        </a>
    </p>

    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th></th>
        </tr>
        @foreach($sets as $set)
        <tr>
            <td>{{ $set->name }} ({{ $set->questions()->count() }} questions)</td>
            <td class="text-right">
                <a class="btn btn-primary btn-sm"
                   href="{{ action('SetController@show', ['set' => $set]) }}">
                    <i class="fas fa-search"></i> Show
                </a>

                <a class="btn btn-primary btn-sm"
                   href="{{ action('SetController@edit', ['set' => $set]) }}">
                    <i class="fas fa-edit"></i> Edit
                </a>

                <form method="POST"
                      action="{{ action('SetController@destroy', ['set' => $set]) }}"
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
