<h4>Files</h4>

<table class='table table-sm table-hover'>
    @foreach ($question->files as $file)
    <tr>
        <td>
            <a href="{{ $file->url() }}" target="_blank">
                {{ $file->basename() }}
            </a>
        </td>
        <td class="text-right">
            <form method="POST"
                  action="{{ action("QuestionController@destroyFile", [
                      "set" => $question->set,
                      "question" => $question,
                      "file" => $file
                  ]) }}"
                  class="d-inline-block">
                @csrf
                @method("delete")
                <button class="btn btn-sm text-danger">
                    <i class="fas fa-times-circle"></i>
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

<form method="POST"
      class="form-inline"
    action="{{ action("QuestionController@uploadFile", ['set' => $question->set, "question" => $question]) }}"
    enctype="multipart/form-data">

  {{ csrf_field() }}
  <input class="form-control" type="file"
         id="file" name="file">

  <button type="submit" class="btn btn-primary">
      <i class="fas fa-upload"></i> Upload
  </button>

</form>