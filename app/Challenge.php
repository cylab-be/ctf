<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function timeStartForHumans() : string
    {
        return $this->timeStart()->format("Y/m/d H:i");
    }

    public function timeStartDiffForHumans() : string
    {
        return $this->timeStart()
                ->diffForHumans(
                    Carbon::now(),
                    \Carbon\CarbonInterface::DIFF_ABSOLUTE
                );
    }

    public function timeEnd() : Carbon
    {
        return Carbon::createFromTimestamp($this->time_end);
    }

    public function timeEndForHumans() : string
    {
        return $this->timeEnd()->format("Y/m/d H:i");
    }

    public function status() : string
    {
        if (time() > $this->time_end) {
            return "FINISHED";
        }

        if ($this->time_start < time()) {
            return "RUNNING";
        }

        return "PLANNED";
    }

    public function ranking()
    {
        return $this->registrations()->orderBy('score', 'DESC')->get();
    }

    public static function upcoming()
    {
        return self::where('time_end', '>', time())
                ->orderBy('time_start')
                ->get();
    }
}
