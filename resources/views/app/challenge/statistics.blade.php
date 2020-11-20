



<div class='card my-3'>
                <div class='card-header'>
                    Question statistics
                </div>

                <div class='card-body'>
                    @foreach ($challenge->sets as $set)
                    <h5>{{ $set->name }}</h5>
                    <table class='table'>
                        <tr>
                            <th>Question</th>
                            <th class='text-right'>Answered correctly by</th>
                        </tr>

                        @foreach ($set->questions as $question)
                        <tr>
                            <td>
                                <a href='{{ action('SetController@show', ['set' => $question->set]) }}#q{{ $question->id }}'>
                                #{{ $loop->iteration }}  {{ $question->name }}
                                </a>
                            </td>
                            <td class='text-right'>
                                {{ $challenge->submissionStatistics()[$question->id] ?? 0 }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endforeach
                </div>
            </div>
