<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Registration $registration
 * @property Question $question
 */
class Submission extends Model
{

    protected $dateFormat = 'U';

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function isCorrect() : bool
    {
        return $this->question->verify($this->flag);
    }
}
