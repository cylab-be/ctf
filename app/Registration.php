<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public static function find(Challenge $challenge, User $user) : ?Registration
    {
        return self::where('challenge_id', $challenge->id)
                ->where('user_id', $user->id)
                ->first();
    }
}
