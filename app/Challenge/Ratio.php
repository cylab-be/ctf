<?php

namespace App\Challenge;

use App\Registration;

/**
 * Description of Ratio
 *
 * @author tibo
 */
class Ratio implements Award
{
    /**
     *
     * @var float
     */
    public $ratio = 0.0;
    
    /**
     *
     * @var \App\Submission
     */
    public $submission;
    
    
    public function compareRegistration(Registration $registration): void
    {
        $total = $registration->submissions->count();
        
        if ($total < 1) {
            return;
        }
        
        $correct = 0;
        foreach ($registration->submissions as $submission) {
            if ($submission->isCorrect()) {
                $correct++;
            }
        }
        
        $ratio = $correct / $total;
        
        if ($ratio > $this->ratio) {
            // found a new best
            $this->ratio = $ratio;
            $this->submission = $registration->submissions->last();
        }
    }
}
