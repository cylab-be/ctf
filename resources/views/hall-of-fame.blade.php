@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1>Challenges</h1>

    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th>End</th>
            <th>Winner</th>
        </tr>
        @foreach($challenges as $challenge)
        <tr>
            <td>{{ $challenge->name }} <span class='text-muted'>{{ $challenge->status() }}</span></td>
            <td>{{ $challenge->timeEndForHumans() }}</td>
            <td>
                {{ $challenge->ranking()[0]["user"]->name }}
                ({{ $challenge->ranking()[0]["score"] }} points)
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
