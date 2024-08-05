<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public function __construct($employee)
    {
        $this->mailData = [
            'title' => 'Welcome to Ardhas Technology!',
            'name' => $employee['name'],
            'email' => $employee['email'],
            'password' => $employee['password'],
        ];
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Successfull Mail',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail.register_mail_format',
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
