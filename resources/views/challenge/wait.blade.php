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

</div>
@endsection
