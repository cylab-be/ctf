<?php

namespace App\Challenge;

use App\Submission;

/**
 * Description of FirstPoint
 *
 * @author tibo
 */
class FirstPoint implements Award
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
    
    
    public function compareWithSubmission(Submission $submission) : void
    {
        if ($submission->created_at->timestamp > $this->time) {
            return;
        }
        
        $this->time = $submission->created_at->timestamp;
        $this->submission = $submission;
    }
}
