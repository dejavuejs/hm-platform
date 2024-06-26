<?php

namespace Orca\Customer\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Verification Mail class
 */
class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationData;

    public function __construct($verificationData)
    {
        $this->verificationData = $verificationData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->verificationData['email'])
            ->from(env('SHOP_MAIL_FROM'))
            ->subject('Verification email')
            ->view('site::emails.customer.verification-email')
            ->with(
                'data',
                [
                    'email' => $this->verificationData['email'],
                    'token' => $this->verificationData['token']
                ]
            );
    }
}