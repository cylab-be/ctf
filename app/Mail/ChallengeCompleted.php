<?php

namespace App\Mail;

use App\Registration;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChallengeCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *
     * @var \App\Registration
     */
    public $registration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.challenge.completed')->subject(
            $this->registration->challenge->name . " : Challenge completed \xF0\x9F\x8E\x89	"
        );
    }
}
