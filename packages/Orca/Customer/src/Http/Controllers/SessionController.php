<?php

namespace Orca\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Orca\Customer\Models\Customer;
use Orca\Customer\Http\Listeners\CustomerEventsHandler;
use Cart;
use Cookie;

/**
 * Session controller for the customer customer
 *
 * @author    Prashant Singh <>
 *
 */
class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    public function __construct()
    {
        $this->middleware('customer')->except(['show','create']);

        $this->_config = request('_config');

        $subscriber = new CustomerEventsHandler;

        Event::subscribe($subscriber);
    }

    public function show()
    {
        if (auth()->guard('customer')->check()) {
            return redirect()->route('customer.profile.index');
        } else {
            return view($this->_config['view']);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (! auth()->guard('customer')->attempt(request(['email', 'password']))) {
            session()->flash('error', trans('site::app.customer.login-form.invalid-creds'));

            return redirect()->back();
        }

        if (auth()->guard('customer')->customer()->status == 0) {
            auth()->guard('customer')->logout();

            session()->flash('warning', trans('site::app.customer.login-form.not-activated'));

            return redirect()->back();
        }

        if (auth()->guard('customer')->customer()->is_verified == 0) {
            session()->flash('info', trans('site::app.customer.login-form.verify-first'));

            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', $request->input('email'), 1));

            auth()->guard('customer')->logout();

            return redirect()->back();
        }

        //Event passed to prepare cart after login
        Event::dispatch('customer.after.login', $request->input('email'));

        return redirect()->intended(route($this->_config['redirect']));
    }

    public function destroy($id)
    {
        auth()->guard('customer')->logout();

        Event::dispatch('customer.after.logout', $id);

        return redirect()->route($this->_config['redirect']);
    }
}