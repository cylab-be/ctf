<?php

namespace App\Challenge;

use App\Submission;

/**
 * Description of FirstPoint
 *
 * @author tibo
 */
class FirstPoint
{
    /**
     *
     * @var integer
     */
    public $time;
    
    
    /**
     *
     * @var \App\Submission
     */
    public $submission;
    
    public function __construct(int $time, ?Submission $submission)
    {
        $this->time = $time;
        $this->submission = $submission;
    }
}
