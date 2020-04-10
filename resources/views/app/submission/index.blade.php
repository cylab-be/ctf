@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1>Last submissions</h1>

    <table class="table table-striped">

        <tr>
            <th>Time</th>
            <th>Question</th>
            <th>User</th>
            <th>Flag</th>
        </tr>

        @foreach($submissions as $submission)
        <tr>
            <td>{{ $submission->created_at }}</td>
            <td>{{ $submission->question_id }}</td>
            <td>{{ $submission->registration->user->name }}</td>
            <td>{{ $submission->flag }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
