<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function score(Challenge $challenge): int
    {
        $submissions = Submission::
                where('challenge_id', $challenge->id)
                ->where('user_id', $this->id)
                ->get();

        $score = 0;
        foreach ($submissions as $submission) {
            if ($submission->question->verify($submission->flag)) {
                $score += 1;
            }
        }

        return $score;
    }

    public function isAdmin(): bool
    {
        return (bool) $this->admin;
    }

    public function gravatar(?int $size = 40): string
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($this->email)));
        $url .= "?s=$size";

        return $url;
    }
}
