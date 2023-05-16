<?php

namespace App\Challenge;

use App\Submission;

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
    
    /**
     * the previous correct submission, the one used for comparison
     * @var \App\Submission
     */
    public $previous;
    
    
    public function compareWithSubmission(Submission $submission): void
    {
        if (! $submission->isCorrect()) {
            return;
        }
        
        if ($this->previous == null) {
            // keep track of this correct submission, to compare at next call
            $this->previous = $submission;
            
            return;
        }
        
        if (! $submission->registration->is($this->previous->registration)) {
            // we are comparing submissions from two different users...
            // keep track of this correct submission, to compare at next call
            $this->previous = $submission;
            
            return;
        }
        
        $delay = $submission->created_at->timestamp - $this->previous->created_at->timestamp;
        if ($delay >= $this->delay) {
            return;
        }
        
        // found a new quickest
        $this->delay = $delay;
        $this->submission = $submission;
        
        // keep track of this correct submission, to compare at next call
        $this->previous = $submission;
    }
}
