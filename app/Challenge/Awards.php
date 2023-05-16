<?php

namespace App\Challenge;

/**
 * Description of Awards
 *
 * @author tibo
 */
class Awards
{
    /**
     *
     * @var FirstPoint
     */
    public $first_point;
    
    public function __construct(\App\Challenge $challenge)
    {
        // Initialize
        $this->first_point = new FirstPoint(PHP_INT_MAX, null);
        
        foreach ($challenge->registrations as $registration) {
            foreach ($registration->submissions as $submission) {
                // First Point
                if ($submission->created_at->timestamp < $this->first_point->time) {
                    $this->first_point = new FirstPoint($submission->created_at->timestamp, $submission);
                }
            }
        }
    }
}
