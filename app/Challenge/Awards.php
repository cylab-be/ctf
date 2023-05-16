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
    
    /**
     *
     * @var Quickest
     */
    public $quickest;
    
    public function __construct(\App\Challenge $challenge)
    {
        // Initialize
        $this->first_point = new FirstPoint();
        $this->quickest = new Quickest();
        
        foreach ($challenge->registrations as $registration) {
            foreach ($registration->submissions as $submission) {
                $this->first_point->compareWithSubmission($submission);
                $this->quickest->compareWithSubmission($submission);
            }
        }
    }
}
