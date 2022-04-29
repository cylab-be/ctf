@extends('layouts.app')

@section('content')
<div class='container-fluid' style='font-size: 1.6rem'>
    <h1 class='text-center my-3' style='font-size: 200%'>{{ $challenge->name }}</h1>



    <p class='text-center my-4'>
        @if ($challenge->isFinished())
        finished since <b>{{ $challenge->timeEndForHumans() }}</b>

        @elseif ($challenge->isStarted())
        time left:
        <span class="timer text-bold" data-seconds-left={{ $challenge->timeEndDiffSeconds() }}></span>

        @else
        start in:
        <span class="timer text-bold" data-seconds-left={{ $challenge->timeStartDiffSeconds() }}></span>
        @endif
    </p>

    <table class='table table-striped'>

        <tr>
            <th>#</th>
            <th>Name</th>
            <th class="text-right">Score</th>
        </tr>
    @foreach ($challenge->ranking() as $registration)
    <tr>
        <td>{{ ($loop->iteration) }}</td>
        <td>
            {{ $registration->user->name }}
            @if ($loop->iteration == 1 && $registration->score > 0)
            <i class="fas fa-medal px-3"></i>
            @endif
        </td>
        <td class="text-right">
            {{ $registration->score }}
        </td>
    </tr>
    @endforeach
    </table>
</div>


@if (!$challenge->isFinished())
<div class="text-muted bottom-right">
    Reload in <span id="reload-countdown">55</span> seconds
</div>

<script type="text/javascript">
    var reload_countdown = 60;
    setInterval(function() {
        reload_countdown -= 1;
        $('#reload-countdown').text(reload_countdown);

        if (reload_countdown === 0) {
            console.log('reload...');
            location.reload();
        }
    }, 1000);
</script>
@endif
@endsection
