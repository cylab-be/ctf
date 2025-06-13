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

        <tr >
            <td class="align-middle">
                <a href="{{ route('scoreboard', ['challenge' => $challenge]) }}">
                    {{ $challenge->name }}
                </a>
                - {{ $challenge->timeEnd()->format('l j F Y') }}
            </td>
            <td class="text-right align-middle">
                {{ $challenge->ranking()->first()->user->name }}
                ({{ $challenge->ranking()->first()->score }} points)
                <img class="rounded"
                     loading="lazy" 
                     src="{{ $challenge->ranking()->first()->user->gravatar(40) }}">
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
