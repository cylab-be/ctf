<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Challenge $challenge
 * @property User $user
 * @property int $score
 * @property \Illuminate\Database\Eloquent\Collection|iterable<Submission> $submissions
 */
class Registration extends Model
{

    protected $dateFormat = 'U';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
    
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function position() : int
    {
        $position = 1;
        foreach ($this->challenge->registrations as $other) {
            if ($other->score > $this->score) {
                $position++;
            }
        }
        return $position;
    }
    
    /**
     * Score as a percentage (e.g. "23%")
     *
     * Useful for displaying progress bar.
     *
     * @return string
     */
    public function scoreProcent() : string
    {
        return (100.0 * $this->score / $this->challenge->maxScore()) . "%";
    }

    public function certificate() : Certificate
    {
        $name = $this->user->name;
        $challenge = $this->challenge->name;
        $date = $this->challenge->timeStart();
        $score = $this->score;
        $rank = $this->position();
        $participants = $this->challenge->participants();
        $link = $this->challenge->scoreboardUrl();
        return new Certificate(
            $name,
            $challenge,
            $date,
            $score,
            $rank,
            $participants,
            $link
        );
    }

    private static $find_cache = [];

    public static function find(Challenge $challenge, User $user) : ?Registration
    {
        $key = $user->id . ":" . $challenge->id;

        if (isset(self::$find_cache[$key])) {
            return self::$find_cache[$key];
        }

        self::$find_cache[$key] = self::where('challenge_id', $challenge->id)
                ->where('user_id', $user->id)
                ->first();

        return self::$find_cache[$key];
    }
}
