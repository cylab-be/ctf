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

    public function timeStartForHumans() : string
    {
        return $this->timeStart()->setTimezone(Auth::user()->timezone)->format("Y/m/d H:i");
    }

    public function timeStartDiffForHumans() : string
    {
        return $this->timeStart()->setTimezone(Auth::user()->timezone)
                ->diffForHumans(
                    Carbon::now(Auth::user()->timezone),
                    \Carbon\CarbonInterface::DIFF_ABSOLUTE
                );
    }

    public function timeEnd() : Carbon
    {
        return Carbon::createFromTimestamp($this->time_end);
    }

    public function timeEndForHumans() : string
    {
        return $this->timeEnd()->setTimezone(Auth::user()->timezone)->format("Y/m/d H:i");
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

    private $ranking = null;

    public function ranking() : array
    {

        if ($this->ranking == null) {
            $ranking = [];

            foreach ($this->users as $user) {
                $score = $user->score($this);
                $ranking[] = [
                    "user" => $user,
                    "score" => $score
                ];
            }

            usort($ranking, function ($l1, $l2){
                return ($l1['score'] > $l2['score']) ? 1 : -1;
            });
            
            $this->ranking = $ranking;
        }

        return $this->ranking;
    }

    public static function upcoming()
    {
        return self::where('time_start', '>', time() - 48 * 3600)
                ->orderBy('time_start')
                ->get();
    }
}
