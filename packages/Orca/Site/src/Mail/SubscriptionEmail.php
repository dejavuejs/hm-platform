<?php

namespace Orca\Site\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
/**
 * Subscriber Mail class
 *
 * @author  Prashant Singh <>
 *
 *
 */
class SubscriptionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriptionData;

    public function __construct($subscriptionData) {
        $this->subscriptionData = $subscriptionData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->subscriptionData['email'])
                ->from(env('SHOP_MAIL_FROM'))
                ->subject('subscription email')
                ->view('site::emails.audience.subscription-email')->with('data', ['content' => 'You Are Subscribed', 'token' => $this->subscriptionData['token']]);
    }
}