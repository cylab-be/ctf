<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

    private function statementHTMLCacheKey() : string
    {
        return "ctf-question-" . $this->id . "-statement";
    }

    public function statementHTML() : string
    {
        $key = $this->statementHTMLCacheKey();

        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $parsedown = new \Parsedown();
        $html = $parsedown->text($this->statement);
        Cache::put($key, $html, 5 * 60);

        return $html;
    }

    public function save(array $options = array()) {
        parent::save($options);
        Cache::forget($this->statementHTMLCacheKey());
    }

    /**
     * Check if the logged in user is allowed to answer this question. This method
     * checks that:
     * 1. the user has not answered correctly
     * 2. the user has not sent the max number of submissions
     *
     * @param \App\Challenge $challenge
     * @return bool
     */
    public function isAvailableFor(Challenge $challenge) : bool
    {
        return (! $this->isSolvedFor($challenge))
        && ($this->remainingSubmissionsFor($challenge) > 0);
    }

    public function isSolvedFor(Challenge $challenge) : bool
    {
        $submissions = $this->getSubmissionsFor($challenge);
        foreach ($submissions as $submission) {
            if ($this->verify($submission->flag)) {
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
        $registration = Registration::find($challenge, $user);
        $submissions = Submission::
                where('registration_id', $registration->id)
                ->where('question_id', $this->id)
                ->get();
        return $submissions;
    }

    public function verify(string $flag)
    {
        return strcasecmp($flag, $this->flag) == 0;
    }
}
