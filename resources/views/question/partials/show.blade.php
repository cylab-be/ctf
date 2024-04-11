<div>
    <h4 class="d-inline-block">
        {{ $question->name }}
    </h4>

    <i class="ml-3 fas fa-star"></i> 
    <b>{{ $question->points }}</b> 
    {{ Str::plural('point', $question->points) }}
</div>
    

{!! $question->statementHTML() !!}

<h5>Files</h5>
<ul>
    @foreach ($question->files as $file)
    <li>
        <a href="{{ $file->url() }}" target="_blank">{{ $file->basename() }}</a>
    </li>
    @endforeach
</ul>