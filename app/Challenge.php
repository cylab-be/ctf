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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Return the list of sets that do NOT belong to this challenge (and can
     * be added to the challenge).
     * @return type
     */
    public function setsAttachable()
    {
        $ids = $this->sets()->allRelatedIds()->all();
        var_dump($ids);

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

    public function timeEnd() : Carbon
    {
        return Carbon::createFromTimestamp($this->time_end);
    }

    public static function upcoming()
    {
        return self::where('time_start', '>', time() - 3600)->get();
    }
}
