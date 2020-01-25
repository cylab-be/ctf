<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $dateFormat = 'U';

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function statementHTML() : string
    {
        return $this->statement;
    }
}
