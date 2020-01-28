@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class='text-center my-5'>{{ $challenge->name }}</h1>

    <h3 class='text-center my-5'>
        will start in <b>{{ $challenge->timeStartDiffForHumans() }}</b>
    </h3>

    <p class='text-center'>
        {{ $challenge->timeStartForHumans() }}
    </p>

    <h5 class='mt-5'>Participants</h5>
    <table class='table'>
        @foreach($challenge->registrations as $registration)
        <tr>
            <td>{{ $registration->user->name }}</td>
        </tr>
        @endforeach
    </table>

</div>

<div class="text-muted bottom-right">
    Reload in <span id="reload-countdown">60</span> seconds
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
@endsection
