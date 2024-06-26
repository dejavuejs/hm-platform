<?php

namespace Orca\Customer\Http\Listeners;
use Cookie;
use Cart;

class CustomerEventsHandler {

    /**
     * Handle Customer login events.
     */
    public function onCustomerLogin($event)
    {
        /**
         * handle the customer login event to manage the after login, if the customer has added any products as guest then
         * the cart items from session will be transferred from cookie to the cart table in the database.
         *
         * Check whether cookie is present or not and then check emptiness and then do the appropriate actions.
         */
        Cart::mergeCart();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen('customer.after.login', 'Orca\Customer\Http\Listeners\CustomerEventsHandler@onCustomerLogin');
    }
}