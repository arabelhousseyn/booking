<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            replyTo: [
                new Address(env('MAIL_NO_REPLAY_ADDRESS'), env('MAIL_FROM_NAME')),
            ],
            subject: trans('exceptions.password_changed'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.passwords.changed',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
