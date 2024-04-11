<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $description
 * @property User $user
 * @property \Illuminate\Database\Eloquent\Collection<Question> $questions
 * @property \Illuminate\Database\Eloquent\Collection<Challenge> $challenges
 */
class Set extends Model
{

    use SoftDeletes;

    protected $dateFormat = 'U';

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function descriptionHTML() : string
    {
        $parsedown = new \Parsedown();
        return $parsedown->text($this->description);
    }

    public function maxScore() : int
    {
        return $this->questions->sum("points");
    }

    private $questions_count = null;

    public function questionsCount() : int
    {
        // cache the query result, as it will be used extensively!
        if ($this->questions_count == null) {
            $this->questions_count = $this->questions()->count();
        }

        return $this->questions_count;
    }
}
