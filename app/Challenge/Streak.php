<?php

namespace App\Challenge;

use App\Registration;

/**
 * Longest streak of correct answers.
 *
 * @author tibo
 */
class Streak implements Award
{
    /**
     *
     * @var int
     */
    public $count = 0;
    
    /**
     *
     * @var \App\Submission
     */
    public $submission;
    
    
    public function compareRegistration(Registration $registration): void
    {
        // longest streak of correct answers for this user
        $user_count = 0;
        
        /** @var \App\Submission $submission */
        foreach ($registration->submissions as $submission) {
            if ($submission->isCorrect()) {
                $user_count++;
                
                if ($user_count > $this->count) {
                    // we found a new best for all users...
                    $this->count = $user_count;
                    $this->submission = $submission;
                }
            } else {
                // end of this streak...
                $user_count = 0;
            }
        }
    }
}
