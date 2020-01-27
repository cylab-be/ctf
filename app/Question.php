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

    public function isAvailableFor(Challenge $challenge) : bool
    {
        return (! $this->isSolvedFor($challenge))
        && ($this->remainingSubmissionsFor($challenge) > 0);
    }

    public function isSolvedFor(Challenge $challenge) : bool
    {
        $submissions = $this->getSubmissionsFor($challenge);
        foreach ($submissions as $submission) {
            if ($submission->flag == $this->flag) {
                return true;
            }
        }

        return false;
    }

    public function remainingSubmissionsFor(Challenge $challenge) : int
    {
        $submissions = $this->getSubmissionsFor($challenge);
        return $this->max_submissions - count($submissions);
    }

    public function getSubmissionsFor(Challenge $challenge)
    {

        $user = Auth::user();
        return Submission::
                where('user_id', $user->id)
                ->where('challenge_id', $challenge->id)
                ->where('question_id', $this->id)->get();
    }
}
