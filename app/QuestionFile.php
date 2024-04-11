<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $filename
 * @property int $question_id
 * @property Question $question
 */
class QuestionFile extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    public function basename() : string
    {
        return basename($this->filename);
    }
    
    public function url() : string
    {
        return Storage::url($this->filename);
    }
}
