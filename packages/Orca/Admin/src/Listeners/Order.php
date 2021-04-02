<?php

namespace Orca\Admin\Listeners;

use Illuminate\Support\Facades\Mail;
use Orca\Admin\Mail\NewOrderNotification;
use Orca\Admin\Mail\NewAdminNotification;
use Orca\Admin\Mail\NewInvoiceNotification;
use Orca\Admin\Mail\NewShipmentNotification;
use Orca\Admin\Mail\NewInventorySourceNotification;

/**
 * Order event handler
 *
 * @author     <>
 *
 */
class Order {

    /**
     * @param mixed $order
     *
     * Send new order Mail to the audience and admin
     */
    public function sendNewOrderMail($order)
    {
        try {
            Mail::queue(new NewOrderNotification($order));

            Mail::queue(new NewAdminNotification($order));
        } catch (\Exception $e) {

        }
    }


    /**
     * @param mixed $invoice
     *
     * Send new invoice mail to the audience
     */
    public function sendNewInvoiceMail($invoice)
    {
        try {
            if ($invoice->email_sent)
                return;

            Mail::queue(new NewInvoiceNotification($invoice));
        } catch (\Exception $e) {

        }
    }

    /**
     * @param mixed $shipment
     *
     * Send new shipment mail to the audience
     */
    public function sendNewShipmentMail($shipment)
    {
        try {
            if ($shipment->email_sent)
                return;

            Mail::queue(new NewShipmentNotification($shipment));

            Mail::queue(new NewInventorySourceNotification($shipment));
        } catch (\Exception $e) {

        }
    }

    /**
     * @param mixed $shipment
     *
     * Send new shipment mail to the audience
     */
    public function updateProductInventory($order)
    {
    }
}