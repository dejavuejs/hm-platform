<?php

namespace Orca\Audience\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Orca\Audience\Models\User;
use Orca\Audience\Http\Listeners\AudienceEventsHandler;
use Cart;
use Cookie;

/**
 * Session controller for the user audience
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
        $this->middleware('audience')->except(['show','create']);

        $this->_config = request('_config');

        $subscriber = new AudienceEventsHandler;

        Event::subscribe($subscriber);
    }

    public function show()
    {
        if (auth()->guard('audience')->check()) {
            return redirect()->route('audience.profile.index');
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

        if (! auth()->guard('audience')->attempt(request(['email', 'password']))) {
            session()->flash('error', trans('site::app.audience.login-form.invalid-creds'));

            return redirect()->back();
        }

        if (auth()->guard('audience')->user()->status == 0) {
            auth()->guard('audience')->logout();

            session()->flash('warning', trans('site::app.audience.login-form.not-activated'));

            return redirect()->back();
        }

        if (auth()->guard('audience')->user()->is_verified == 0) {
            session()->flash('info', trans('site::app.audience.login-form.verify-first'));

            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', $request->input('email'), 1));

            auth()->guard('audience')->logout();

            return redirect()->back();
        }

        //Event passed to prepare cart after login
        Event::dispatch('audience.after.login', $request->input('email'));

        return redirect()->intended(route($this->_config['redirect']));
    }

    public function destroy($id)
    {
        auth()->guard('audience')->logout();

        Event::dispatch('audience.after.logout', $id);

        return redirect()->route($this->_config['redirect']);
    }
}