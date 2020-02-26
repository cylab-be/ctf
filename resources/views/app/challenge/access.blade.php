@extends('layouts.app')

@section('content')
<div class='container-fluid' style='font-size: 4rem'>
    <p class='text-center my-4'>https://ctf.cylab.be</p>
    <h1 class='text-center my-3' style='font-size: 150%'>{{ $challenge->name }}</h1>
    <p class='text-center my-4'>access code: <b>{{ $challenge->code }}</b></p>
</div>

@endsection
