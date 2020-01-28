@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container">
    <h1>Users</h1>

    <!--
    <p>
        <a href="{{ action('UserController@create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> New
        </a>
    </p>
    -->

    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Administrator</th>
            <th></th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->isAdmin() ? 'YES' : 'NO' }}</td>
            <td class="text-right">
                <a class="btn btn-primary btn-sm"
                   href="{{ action('UserController@show', ['user' => $user]) }}">
                    <i class="fas fa-search"></i> Show
                </a>

                <!--
                <a class="btn btn-primary btn-sm"
                   href="{{ action('UserController@edit', ['user' => $user]) }}">
                    <i class="fas fa-edit"></i> Edit
                </a>
                -->

                <form method="POST"
                      action="{{ action('UserController@destroy', ['user' => $user]) }}"
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
