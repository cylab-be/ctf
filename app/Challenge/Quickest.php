<?php

namespace App\Challenge;

use App\Registration;

/**
 * Quickest correct answer
 *
 * @author tibo
 */
class Quickest implements Award
{
    /**
     *
     * @var integer
     */
    public $delay = PHP_INT_MAX;
    
    /**
     *
     * @var \App\Submission
     */
    public $submission;
    
    
    public function compareRegistration(Registration $registration): void
    {
        // time of last correct submission for this user
        $time_last_correct = $registration->challenge->time_start;
        
        /** @var \App\Submission $submission */
        foreach ($registration->submissions as $submission) {
            if (! $submission->isCorrect()) {
                continue;
            }

            $delay = $submission->created_at->timestamp - $time_last_correct;
            
            if ($delay < $this->delay) {
                // found a new quickest
                $this->delay = $delay;
                $this->submission = $submission;
            }

            // keep track for next iteration
            $time_last_correct = $submission->created_at->timestamp;
        }
    }
}
