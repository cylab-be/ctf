@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class='text-center'>{{ $challenge->name }}</h1>

    <table class='table table-striped'>
    @foreach ($challenge->users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->score($challenge) }}</td>
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
