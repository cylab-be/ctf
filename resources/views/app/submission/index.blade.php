@extends('layouts.app')

@section('title', 'Challenges')

@section('content')
<div class="container">
    <h1>Last submissions</h1>

    <p>
        <input type="text" class="form-control d-inline col-md-2" name="search" id="search" placeholder="Filter...">
    </p>

    <table class="table table-striped">

        <thead>
        <tr>
            <th>Time</th>
            <th>Question</th>
            <th>User</th>
            <th>Flag</th>
        </tr>
        </thead>

        <tbody id="submissions">
        @foreach($submissions as $submission)
        <tr>
            <td>{{ $submission->created_at }}</td>
            <td>{{ $submission->question_id }}</td>
            <td>{{ $submission->registration->user->name }}</td>
            <td>{{ $submission->flag }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>


<script type="text/javascript" defer>
window.addEventListener('DOMContentLoaded', function() {
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#submissions tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection
