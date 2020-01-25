@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $set->name }}</div>

                <div class="card-body">
                    <p>Name: {{ $set->name }}</p>

                    <div>
                        <a class="btn btn-primary"
                           href="{{ action('SetController@edit', ['set' => $set]) }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form method="POST"
                              action="{{ action('SetController@destroy', ['set' => $set]) }}"
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
