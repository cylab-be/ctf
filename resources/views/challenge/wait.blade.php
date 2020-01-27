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
        @foreach($challenge->users as $user)
        <tr>
            <td>{{ $user->name }}</td>
        </tr>
        @endforeach
    </table>

</div>
@endsection
