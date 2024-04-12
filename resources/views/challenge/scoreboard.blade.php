@extends('layouts.app')

@section('content')
<div class='container'>
    <div class="row">
        <div class="col-md-7">
            <div class="card" style="min-height: 600px">
                <div class="card-body">
                    <h1 class='my-2''>
                        {{ $challenge->name }}
                    </h1>

                    <p class='mb-4'>
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

                    <table class='table'>
                        @foreach ($challenge->ranking() as $registration)
                        <tr>
                            <td class="align-middle">
                                {{ ($loop->iteration) }}
                            </td>
                            <td class="text-center">
                                <img class="rounded" src="{{ $registration->user->gravatar(30) }}">
                            </td>
                            <td class="align-middle">
                                {{ $registration->user->name }}
                            </td>
                            <td class="align-middle" style="width: 40%">
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $registration->scoreProcent() }}"></div>
                                </div>
                            </td>
                            <td class="text-right align-middle">
                                {{ $registration->score }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        
        @php
        $awards = $challenge->awards();
        @endphp
        
        <div class="col-md-5">
            @if (! is_null($awards->first_point->submission))
            <div class="card mb-2">
                <div class="card-body">
                    <h4>
                        First Blood : {{ $awards->first_point->submission->registration->user->name }}
                    </h4>

                    <p class="text-muted">
                        got first flag in <b>{{ $awards->first_point->timeAfterStart() }}</b> seconds
                    </p>
                </div>
            </div>
            @endif


            @if (! is_null($awards->quickest->submission))
            <div class="card mb-2">
                <div class="card-body">
                    <h4>
                        Speedy Gonzales : {{ $awards->quickest->submission->registration->user->name }}
                    </h4>

                    <p class="text-muted">
                        got a flag in <b>{{ $awards->quickest->delay }}</b> seconds
                    </p>
                </div>
            </div>
            @endif


            @if (! is_null($awards->ratio->submission))
            <div class="card mb-2">
                <div class="card-body">
                    <h4>Sniper : {{ $awards->ratio->submission->registration->user->name }}</h4>

                    <p class="text-muted">
                        <b>{{ round($awards->ratio->ratio * 100) }}%</b> of correct answers
                    </p>
                </div>
            </div>
            @endif

            @if (! is_null($awards->streak->submission))
            <div class="card mb-2">
                <div class="card-body">
                    <h4>Longest streak : {{ $awards->streak->submission->registration->user->name }}</h4>

                    <p class="text-muted">
                        <b>{{ $awards->streak->count }}</b> correct answers in a row
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


@if (!$challenge->isFinished())
<div class="text-muted bottom-right">
    Reload in <span id="reload-countdown">10</span> seconds
</div>

<script type="text/javascript">
    var reload_countdown = 10;
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
