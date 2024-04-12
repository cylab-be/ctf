<h2>{{ $set->name }}</h2>

@if ($set->description)
<div class='card mb-4'>
    <div class='card-body'>
        {!! $set->descriptionHTML() !!}
    </div>
</div>
@endif

@foreach ($set->questions as $question)
<div class="card mb-4 {{ $question->isSolvedFor($challenge) ? 'border-success' : '' }}"
     id='q{{ $question->id }}'>
    <div class='card-body'>
        @include("question.partials.show", ["question" => $question])
    </div>
    <div class='card-footer'>
        @if ($question->isAvailableFor($challenge))
        <form method="POST"
              class="form-inline"
              action="{{ action('UserChallengeController@submit', ['challenge' => $challenge, 'question' => $question]) }}"
              style="display: inline-block">
            {{ csrf_field() }}

            <input type="text" class='form-control' name='flag'
                   autocomplete="off" placeholder="Flag">

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-check"></i> Submit
            </button>
        </form>
        @endif

        <b>{{ $question->remainingSubmissionsFor($challenge) }}</b> remaining submissions...
    </div>
</div>
@endforeach