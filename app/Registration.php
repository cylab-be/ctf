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

    public static function find(Challenge $challenge, User $user) : ?Registration
    {
        return self::where('challenge_id', $challenge->id)
                ->where('user_id', $user->id)
                ->first();
    }
}
