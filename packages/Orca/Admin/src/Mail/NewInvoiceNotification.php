<?php

namespace Orca\Admin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * New Invoice Mail class
 *
 * @author     <>
 *
 */
class NewInvoiceNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The invoice instance.
     *
     * @var Invoice
     */
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @param mixed $invoice
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->invoice->order;

        return $this->to($order->audience_email, $order->audience_full_name)
                ->from(env('SHOP_MAIL_FROM'))
                ->subject(trans('site::app.mail.invoice.subject', ['order_id' => $order->id]))
                ->view('site::emails.sales.new-invoice');
    }
}
