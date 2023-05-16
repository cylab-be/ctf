<?php

namespace App\Challenge;

use App\Registration;

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
    public $time = PHP_INT_MAX;
    
    
    /**
     *
     * @var \App\Submission
     */
    public $submission;
    
    
    public function compareRegistration(Registration $registration) : void
    {
        
        foreach ($registration->submissions as $submission) {
            if ($submission->created_at->timestamp > $this->time) {
                return;
            }

            $this->time = $submission->created_at->timestamp;
            $this->submission = $submission;
        }
    }
    
    public function timeAfterStart() : int
    {
        return $this->time - $this->submission->registration->challenge->time_start;
    }
}
