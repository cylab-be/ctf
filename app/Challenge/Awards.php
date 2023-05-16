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
    
    /**
     *
     * @var Ratio
     */
    public $ratio;
    
    public function __construct(\App\Challenge $challenge)
    {
        // Initialize
        $this->first_point = new FirstPoint();
        $this->quickest = new Quickest();
        $this->ratio = new Ratio();
        
        foreach ($challenge->registrations as $registration) {
            $this->first_point->compareRegistration($registration);
            $this->quickest->compareRegistration($registration);
            $this->ratio->compareRegistration($registration);
        }
    }
}
