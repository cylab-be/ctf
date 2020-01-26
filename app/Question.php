<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{

    const DEFAULT_MAX_SUBMISSIONS = 3;

    protected $dateFormat = 'U';

    public function __construct(array $attributes = array())
    {
        $this->max_submissions = self::DEFAULT_MAX_SUBMISSIONS;
        parent::__construct($attributes);
    }

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function statementHTML() : string
    {
        $parsedown = new \Parsedown();
        return $parsedown->text($this->statement);
    }

    public function isSolvedFor(Challenge $challenge) : bool
    {
        $user = Auth::user();

        $submissions = Submission::
                where('user_id', $user->id)
                ->where('challenge_id', $challenge->id)
                ->where('question_id', $this->id)->get();

        foreach ($submissions as $submission) {
            if ($submission->flag == $this->flag) {
                return true;
            }
        }

        return false;
    }
}
