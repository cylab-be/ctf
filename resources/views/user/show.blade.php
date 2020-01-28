@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                    <p>Name: {{ $user->name }}</p>

                    <div>
                        <!--
                        <a class="btn btn-primary"
                           href="{{ action('UserController@edit', ['user' => $user]) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        -->

                        <form method="POST"
                              action="{{ action('UserController@destroy', ['user' => $user]) }}"
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
    </div>
</div>
@endsection
