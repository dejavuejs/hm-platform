<?php

namespace Orca\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * New Admin Mail class
 *
 * @author     <>
 *
 */
class NewAudienceNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The audience instance.
     *
     * @var audience
     */
    public $audience;

    /**
     * The password instance.
     *
     * @var password
     */
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($audience, $password)
    {
        $this->audience = $audience;

        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->audience->email)
                ->subject(trans('site::app.mail.audience.subject'))
                ->view('site::emails.audience.new-audience')->with(['audience' => $this->audience, 'password' => $this->password]);
    }
}