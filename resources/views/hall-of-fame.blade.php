@extends('layouts.app')

@section('title', 'Hall of Fame')

@section('content')
<div class="container">
    <h1 class='my-5 text-center'>
        <i class="fas fa-trophy px-4"></i>
        Hall of Fame
        <i class="fas fa-trophy px-4"></i>
    </h1>

    <table class="table table-striped">
        <tr>
            <th>Challenge</th>
            <th class="text-right">Winner</th>
        </tr>
        @foreach($challenges as $challenge)

        @if($challenge->ranking()->count() == 0)
        @continue
        @endif

        <tr>
            <td>
                <a href="{{ route('scoreboard', ['challenge' => $challenge]) }}">
                    {{ $challenge->name }}
                </a>
                - {{ $challenge->timeEnd()->format('l j F Y') }}
            </td>
            <td class="text-right">
                {{ $challenge->ranking()->first()->user->name }}
                ({{ $challenge->ranking()->first()->score }} points)
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
