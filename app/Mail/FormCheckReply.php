<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormCheckReply extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reply;
    public $videoUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $reply, $videoUrl)
    {
        $this->user = $user;
        $this->reply = $reply;
        $this->videoUrl = $videoUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Form Check Has a Reply',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.form_check_reply', // your Blade view
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
