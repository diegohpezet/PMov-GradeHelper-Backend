<?php

namespace App\Mail;

use App\Models\Gradeable;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExerciseCorrection extends Mailable
{
    use Queueable, SerializesModels;

    public $gradeable;

    /**
     * Create a new message instance.
     */
    public function __construct(Gradeable $gradeable)
    {
        $this->gradeable = $gradeable;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'PMov | You have a new correction',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.exercise-correction',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
