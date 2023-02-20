<?php

namespace App\Mail;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public string $url;

    public function __construct(public User|Seller $user, private string $token)
    {
        $this->generateUrl();
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            replyTo: [
                new Address(env('MAIL_NO_REPLAY_ADDRESS'), env('MAIL_FROM_NAME')),
            ],
            subject: trans('email.mail_password_reset_title'),
        );
    }


    public function content(): Content
    {
        return new Content(
            markdown: 'emails.passwords.reset',
        );
    }


    public function attachments(): array
    {
        return [];
    }

    private function generateUrl(): void
    {
        $this->url = ($this->user instanceof User) ?
            env('APP_URL').'/'.'user-password-reset'."?email={$this->user->email}&token={$this->token}" :
            env('APP_URL').'/'.'seller-password-reset'."?email={$this->user->email}&token={$this->token}";
    }
}
