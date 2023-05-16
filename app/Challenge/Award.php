<?php

namespace App\Challenge;

use App\Submission;

/**
 *
 * @author tibo
 */
interface Award
{
    public function compareWithSubmission(Submission $submission) : void;
}
