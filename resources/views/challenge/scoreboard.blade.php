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

    <div class="row">
        <div class="col">
            <table class='table table-striped'>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th class="text-right">Score</th>
                </tr>
            @foreach ($challenge->ranking() as $registration)
            <tr>
                <td class="align-middle">
                    @if ($loop->iteration == 1 && $registration->score > 0)
                    <img src="/images/gold-40.png">
                    @elseif ($loop->iteration == 2 && $registration->score > 0)
                    <img src="/images/silver-40.png">
                    @elseif ($loop->iteration == 3 && $registration->score > 0)
                    <img src="/images/bronze-40.png">
                    @else
                    {{ ($loop->iteration) }}
                    @endif
                    
                </td>
                <td class="align-middle">
                    <img class="rounded"
                         src="{{ $registration->user->gravatar(40) }}">
                    {{ $registration->user->name }}
                </td>
                <td class="text-right align-middle">
                    {{ $registration->score }}
                </td>
            </tr>
            @endforeach
            </table>
        </div>
        
        
        @php
        $awards = $challenge->awards();
        @endphp
        <div class="col">
            <table class="table table-striped">
                <tr>
                    <th colspan="2">
                        Special awards
                    </th>
                </tr>
                <tr>
                    <td>First point</td>
                    <td class="text-right">
                        @if (! is_null($awards->first_point->submission))
                        <img class="rounded"
                         src="{{ $awards->first_point->submission->registration->user->gravatar(40) }}">
                        {{ $awards->first_point->submission->registration->user->name }}
                        @endif
                    </td>
                </tr>
                @if (! is_null($awards->first_point->submission))
                <tr>
                    <td colspan="2" class="text-muted text-right">
                        got first flag in <b>{{ $awards->first_point->timeAfterStart() }}</b> seconds
                    </td>
                </tr>
                @endif
                
                <tr>
                    <td>Quickest</td>
                    <td class="text-right">
                        @if (! is_null($awards->quickest->submission))
                        <img class="rounded"
                         src="{{ $awards->quickest->submission->registration->user->gravatar(40) }}">
                        {{ $awards->quickest->submission->registration->user->name }}
                        @endif
                    </td>
                </tr>
                
                @if (! is_null($awards->quickest->submission))
                <tr>
                    <td colspan="2" class="text-muted text-right">
                        got a flag in <b>{{ $awards->quickest->delay }}</b> seconds
                    </td>
                </tr>
                @endif
                
            </table>
        </div>
    </div>
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
