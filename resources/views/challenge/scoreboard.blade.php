@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class='text-center'>{{ $challenge->name }}</h1>

    <table class='table table-striped'>
    @foreach ($challenge->users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->score($challenge) }}</td>
    </tr>
    @endforeach
    </table>
</div>
@endsection
