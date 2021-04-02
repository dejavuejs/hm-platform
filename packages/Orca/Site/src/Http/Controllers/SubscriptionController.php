<?php

namespace Orca\Site\Http\Controllers;

use Orca\Site\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Orca\Site\Mail\SubscriptionEmail;
use Orca\Audience\Repositories\AudienceRepository as Audience;
use Orca\Core\Repositories\SubscribersListRepository as Subscription;

/**
 * Subscription controller
 *
 * @author    Prashant Singh <>
 *
 */
class SubscriptionController extends Controller
{
    /**
     * User object
     *
     * @var array
     */
    protected $user;

    /**
     * Audience Repository object
     *
     * @var array
     */
    protected $audience;

    /**
     * Subscription List Repository object
     *
     * @var array
     */
    protected $subscription;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Audience $audience, Subscription $subscription)
    {
        $this->subscription = $subscription;

        $this->_config = request('_config');
    }

    /**
     * Subscribes email to the email subscription list
     *
     * @return Redirect
     */
    public function subscribe()
    {
        $this->validate(request(), [
            'subscriber_email' => 'email|required'
        ]);

        $email = request()->input('subscriber_email');

        $unique = 0;

        $alreadySubscribed = $this->subscription->findWhere(['email' => $email]);

        $unique = function () use ($alreadySubscribed) {
            if ($alreadySubscribed->count() > 0) {
                return 0;
            } else {
                return 1;
            }
        };

        if ($unique()) {
            $token = uniqid();

            $subscriptionData['email'] = $email;
            $subscriptionData['token'] = $token;

            $mailSent = true;

            try {
                Mail::queue(new SubscriptionEmail($subscriptionData));

                session()->flash('success', trans('site::app.subscription.subscribed'));
            } catch (\Exception $e) {
                session()->flash('error', trans('site::app.subscription.not-subscribed'));

                $mailSent = false;
            }

            $result = false;

            if ($mailSent) {
                $result = $this->subscription->create([
                    'email' => $email,
                    'channel_id' => core()->getCurrentChannel()->id,
                    'is_subscribed' => 1,
                    'token' => $token
                ]);

                if (!$result) {
                    session()->flash('error', trans('site::app.subscription.not-subscribed'));

                    return redirect()->back();
                }
            }
        } else {
            session()->flash('error', trans('site::app.subscription.already'));
        }

        return redirect()->back();
    }

    /**
     * To unsubscribe from a the subcription list
     *
     * @var string $token
     */
    public function unsubscribe($token)
    {
        $subscriber = $this->subscription->findOneByField('token', $token);

        if (isset($subscriber))
            if ($subscriber->count() > 0 && $subscriber->is_subscribed == 1 && $subscriber->update(['is_subscribed' => 0])) {
                session()->flash('info', trans('site::app.subscription.unsubscribed'));
            } else {
                session()->flash('info', trans('site::app.subscription.already-unsub'));
            }

        return redirect()->route('Site.home.index');
    }
}
