@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card my-3">
                <div class="card-body">
                    <div class="border rounded-circle bg-white gravatar">
                        <img src="{{ $user->gravatar(140) }}">
                    </div>

                    <p><b>{{ $user->name }}</b></p>
                    <p>{{ $user->email }}</p>
                    <p>Password: *****</p>

                    <p>
                        <a class="btn btn-primary"
                           href='{{ action('AccountController@edit')  }}'>
                            <i class="fas fa-edit"></i> Modify
                        </a>
                    </p>

                    <p>
                        Set your avatar on 
                        <a href="https://gravatar.com/" target="_blank">
                            https://gravatar.com/
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card my-3">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Challenge</th>
                            <th>Score</th>
                            <th>Position</th>
                            <th></th>
                        </tr>

                        @foreach($user->registrations as $registration)
                        @php
                        $challenge = $registration->challenge
                        @endphp
                        @if ($challenge !== null)
                        <tr>
                            <td>
                                <a href="{{ action('UserChallengeController@show', ['challenge' => $challenge]) }}">
                                    {{ $challenge->name }}
                                </a>
                                - {{ $challenge->timeEnd()->format('l j F Y') }}
                            </td>
                            <td>{{ $registration->score }}</td>
                            <td class="text-right">
                                @if($registration->position() == 1)
                                <i class="fas fa-medal"></i>
                                @endif
                                {{ $registration->position() }} /
                                {{ $challenge->participants() }}
                            </td>
                            <td>
                                <a class='btn btn-sm btn-primary'
                                   href="{{ route('certificate', ['registration' => $registration]) }}">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    Certificate
                                </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </table>

                    <p>
                        <a class="btn btn-primary" href="{{ route('challenges') }}">
                            <i class="fas fa-sign-in-alt"></i> Join another challenge
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
