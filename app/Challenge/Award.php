<?php

namespace App\Challenge;

use App\Registration;

/**
 *
 * @author tibo
 */
interface Award
{
    public function compareRegistration(Registration $registration) : void;
}
