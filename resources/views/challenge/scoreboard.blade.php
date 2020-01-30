@extends('layouts.app')

@section('content')
<div class='container-fluid' style='font-size: 1.6rem'>
    <h1 class='text-center my-3' style='font-size: 200%'>{{ $challenge->name }}</h1>
    <p class='text-center my-4'>time left: <b>{{ $challenge->timeEndDiffForHumans() }}</b></p>

    <table class='table table-striped'>

        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
    @foreach ($challenge->ranking() as $registration)
    <tr>
        <td>{{ ($loop->index + 1) }}</td>
        <td>{{ $registration->user->name }}</td>
        <td>{{ $registration->score }}</td>
    </tr>
    @endforeach
    </table>



</div>

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
@endsection
