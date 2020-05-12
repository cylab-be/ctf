<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
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
}
