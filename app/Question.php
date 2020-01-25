<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{
    protected $dateFormat = 'U';

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
