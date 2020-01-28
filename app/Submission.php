<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

    protected $dateFormat = 'U';

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
