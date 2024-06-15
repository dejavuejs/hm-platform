<?php

namespace Orca\Customer\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class CustomerResetPassword extends ResetPassword
{

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_customer_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->from(env('SHOP_MAIL_FROM'))
            ->subject(__('site::app.mail.forget-password.subject') )
            ->view('site::emails.customer.forget-password', [
                'customer_name' => $notifiable->name,
                'token' => $this->token
            ]);
    }
}
