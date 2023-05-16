<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Registration $registration
 * @property Question $question
 * @property integer $points
 */
class Submission extends Model
{

    protected $dateFormat = 'U';
    
    public function save(array $options = [])
    {
        
        if ($this->question->verify($this->flag)) {
            $this->points = $this->question->points;
        }

        return parent::save($options);
    }

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
        return $this->points > 0;
    }
}
