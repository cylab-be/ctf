@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1 class='my-5'>
        <i class="fas fa-trophy"></i>
        Hall of Fame
    </h1>

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
                @if(count($challenge->ranking()) > 0)
                @php
                $first = $challenge->ranking()->first();
                @endphp

                {{ $first->user->name }}
                ({{ $first->score }} points)
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
