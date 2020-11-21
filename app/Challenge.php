<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $dateFormat = 'U';

    public function __construct(array $attributes = array())
    {
        $this->time_start = time();
        $this->time_end = time() + 7200;
        parent::__construct($attributes);
    }

    public function sets()
    {
        return $this->belongsToMany(Set::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Return the list of sets that do NOT belong to this challenge (and can
     * be added to the challenge).
     * @return type
     */
    public function setsAttachable()
    {
        $ids = $this->sets()->allRelatedIds()->all();
        $r = [];
        foreach (Set::all() as $set) {
            if (!in_array($set->id, $ids)) {
                $r[] = $set;
            }
        }

        return $r;
    }

    public function timeStart() : Carbon
    {
        return Carbon::createFromTimestamp($this->time_start);
    }

    const TIME_FORMAT = "l j F Y @ H:i";
    const TIME_FORMAT_PICKER = "Y/m/d H:i";

    public function timeStartForHumans() : string
    {
        return $this->timeStart()->format(self::TIME_FORMAT);
    }

    public function timeStartForPicker() : string
    {
        return $this->timeStart()->format(self::TIME_FORMAT_PICKER);
    }

    public function timeStartDiffForHumans() : string
    {
        return $this->timeStart()
                ->diffForHumans(
                    Carbon::now(),
                    \Carbon\CarbonInterface::DIFF_ABSOLUTE
                );
    }

    /**
     * Number of seconds remaining before the start of the challenge.
     * Returns a negative value if the challenge is already started.
     *
     * @return int
     */
    public function timeStartDiffSeconds() : int
    {
        return $this->time_start - time();
    }

    public function timeEnd() : Carbon
    {
        return Carbon::createFromTimestamp($this->time_end);
    }

    public function timeEndForHumans() : string
    {
        return $this->timeEnd()->format(self::TIME_FORMAT);
    }

    public function timeEndForPicker() : string
    {
        return $this->timeEnd()->format(self::TIME_FORMAT_PICKER);
    }

    public function timeEndDiffSeconds() : int
    {
        return $this->time_end - time();
    }

    public function timeEndDiffForHumans() : string
    {
        return $this->timeEnd()
                ->diffForHumans(
                    Carbon::now(),
                    \Carbon\CarbonInterface::DIFF_ABSOLUTE
                );
    }

    public function status() : string
    {
        if ($this->isFinished()) {
            return "FINISHED";
        }

        if ($this->isStarted()) {
            return "RUNNING";
        }

        return "PLANNED";
    }

    public function isStarted() : bool
    {
        return $this->time_start < time();
    }

    public function isFinished() : bool
    {
        return time() > $this->time_end;
    }

    public function ranking()
    {
        return $this->registrations()->orderBy('score', 'DESC')->get();
    }

    public function participants()
    {
        return $this->registrations()->count();
    }

    public function maxScore() : int
    {
        $max = 0;
        foreach ($this->sets as $set) {
            $max += $set->maxScore();
        }
        return $max;
    }

    public function submissions()
    {
        return $this->hasManyThrough(Submission::class, Registration::class);
    }

    public function latestSubmissions(int $count = 100)
    {
        return $this->submissions()->orderBy('id', 'desc')->take($count)->get();
    }

    public function scoreboardUrl() : string
    {
        return route('scoreboard', ['challenge' => $this]);
    }

    private $stats;

    public function submissionStatistics() : array
    {
        if ($this->stats !== null) {
            return $this->stats;
        }

        $stats = [];
        foreach ($this->submissions as $submission) {
            // this question was deleted from the set
            if ($submission->question === null) {
                continue;
            }

            if (!$submission->isCorrect()) {
                continue;
            }

            if (! isset($stats[$submission->question_id])) {
                $stats[$submission->question_id] = 1;
                continue;
            }

            $stats[$submission->question_id]++;
        }
        $this->stats = $stats;
        return $this->stats;
    }

    public static function upcoming()
    {
        return self::where('time_end', '>', time())
                ->orderBy('time_start')
                ->get();
    }

    public static function finished()
    {
        return self::where('time_end', '<', time())
                ->orderBy('time_end', 'DESC')
                ->get();
    }
}
