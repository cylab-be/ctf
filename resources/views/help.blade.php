@extends('layouts.app')

@section('title', 'Help')

@section('content')
<div class="container">
    <h1 class='my-5 text-center'>
        Getting started
    </h1>

    <div class='row justify-content-center mb-4'>
        <div class='col-lg-10 col-12'>
            <div class='card'>

                <div class='card-body'>
                <img src='/images/ctf-challenges.png' class='img-fluid border my-2'>
                <p>Before joining a challenge, you need to create an account (or login if you already have an account).</p>
                </div>
            </div>
        </div>
    </div>

    <div class='row justify-content-center mb-4'>
        <div class='col-lg-10 col-12'>
            <div class='card'>

                <div class='card-body'>
                <img src='/images/ctf-join.png' class='img-fluid border my-2'>
                <p>The organizer will give you an access code to join the challenge.</p>
                </div>
            </div>
        </div>
    </div>

    <div class='row justify-content-center mb-4'>
        <div class='col-lg-10 col-12'>
            <div class='card'>

                <div class='card-body'>
                <img src='/images/ctf-questions.png' class='img-fluid border my-2'>
                <p>Each challenge consists of a list of questions.</p>
                </div>
            </div>
        </div>
    </div>

    <div class='row justify-content-center mb-4'>
        <div class='col-lg-10 col-12'>
            <div class='card'>

                <div class='card-body'>
                <img src='/images/ctf-correct.png' class='img-fluid border my-2'>
                <p>You are directly notified if you answer correctly.</p>
                </div>
            </div>
        </div>
    </div>

    <div class='row justify-content-center mb-4'>
        <div class='col-lg-10 col-12'>
            <div class='card'>

                <div class='card-body'>
                <img src='/images/ctf-scoreboard.png' class='img-fluid border my-2'>
                <p>The scoreboard is updated in real time and shows how you perform compared to the other participants.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
