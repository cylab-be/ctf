@extends('layouts.app')

@section('content')
<div class='container-fluid' style='font-size: 1.6rem'>
    <h1 class='text-center my-3' style='font-size: 200%'>{{ $challenge->name }}</h1>

    @if ($challenge->isFinished())
    <p class='text-center my-4'>finished since <b>{{ $challenge->timeEndForHumans() }}</b></p>
    @else
    <p class='text-center my-4'>time left: <b>{{ $challenge->timeEndDiffForHumans() }}</b></p>
    @endif

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
            @if ($loop->iteration == 1)
            <i class="fas fa-medal px-3"></i>
            @endif
        </td>
        <td class="text-right">{{ $registration->score }}</td>
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
