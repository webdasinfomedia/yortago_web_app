<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormCheckUploaded extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $videoUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $videoUrl)
    {
        $this->user = $user;
        $this->videoUrl = $videoUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Form Check Uploaded',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.form_check_uploaded', // use your Blade view
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
