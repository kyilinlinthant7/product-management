<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;
    public $resetLink;

    public function __construct($subject, $message, $resetLink)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->resetLink = $resetLink; 
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.forgot-password-mail')
                    ->with([
                        'message' => $this->message,
                        'resetLink' => $this->resetLink,
                    ]);
    }
}

