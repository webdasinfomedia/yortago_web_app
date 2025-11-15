<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InPersonContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $contentText;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectText, $contentText, $email)
    {
        $this->subjectText = $subjectText;
        $this->contentText = $contentText;
        $this->email = $email;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('emails.in_person_contact_reply')
                    ->with([
                        'subject' => $this->subjectText,
                        'content' => $this->contentText,
                        'email' => $this->email,
                    ]);
    }
}
