<?php

namespace Orca\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * New Order Mail class
 *
 * @author     <>
 *
 */
class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->order->audience_email, $this->order->audience_full_name)
                ->from(env('SHOP_MAIL_FROM'))
                ->subject(trans('site::app.mail.order.subject'))
                ->view('site::emails.sales.new-order');
    }
}
