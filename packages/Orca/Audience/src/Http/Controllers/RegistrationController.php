<?php

namespace Orca\Audience\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Orca\Audience\Mail\VerificationEmail;
use Illuminate\Routing\Controller;
use Orca\Audience\Repositories\AudienceRepository;
use Orca\Audience\Repositories\AudienceGroupRepository;
use Cookie;

/**
 * Registration controller
 *
 * @author    Prashant Singh <>
 *
 */
class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;
    protected $audience;
    protected $audienceGroup;

    /**
     * @param AudienceRepository object $audience
     */
    public function __construct(AudienceRepository $audience, AudienceGroupRepository $audienceGroup)
    {
        $this->_config = request('_config');
        $this->audience = $audience;
        $this->audienceGroup = $audienceGroup;
    }

    /**
     * Opens up the user's sign up form.
     *
     * @return view
     */
    public function show()
    {
        return view($this->_config['view']);
    }

    /**
     * Method to store user's sign up form data to DB.
     *
     * @return Mixed
     */
    public function create(Request $request)
    {
        $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required|unique:audiences,email',
            'password' => 'confirmed|min:6|required',
        ]);

        $data = request()->input();

        $data['password'] = bcrypt($data['password']);

        $data['channel_id'] = core()->getCurrentChannel()->id;

        if (core()->getConfigData('audience.settings.email.verification')) {
            $data['is_verified'] = 0;
        } else {
            $data['is_verified'] = 1;
        }

        $data['audience_group_id'] = $this->audienceGroup->findOneWhere(['code' => 'general'])->id;

        $verificationData['email'] = $data['email'];
        $verificationData['token'] = md5(uniqid(rand(), true));
        $data['token'] = $verificationData['token'];

        Event::dispatch('audience.registration.before');

        $audience = $this->audience->create($data);

        Event::dispatch('audience.registration.after', $audience);

        if ($audience) {
            if (core()->getConfigData('audience.settings.email.verification')) {
                try {
                    Mail::queue(new VerificationEmail($verificationData));

                    session()->flash('success', trans('site::app.audience.signup-form.success-verify'));
                } catch (\Exception $e) {
                    session()->flash('info', trans('site::app.audience.signup-form.success-verify-email-unsent'));
                }
            } else {
                session()->flash('success', trans('site::app.audience.signup-form.success'));
            }

            return redirect()->route($this->_config['redirect']);
        } else {
            session()->flash('error', trans('site::app.audience.signup-form.failed'));

            return redirect()->back();
        }
    }

    /**
     * Method to verify account
     *
     * @param string $token
     */
    public function verifyAccount($token)
    {
        $audience = $this->audience->findOneByField('token', $token);

        if ($audience) {
            $audience->update(['is_verified' => 1, 'token' => 'NULL']);

            session()->flash('success', trans('site::app.audience.signup-form.verified'));
        } else {
            session()->flash('warning', trans('site::app.audience.signup-form.verify-failed'));
        }

        return redirect()->route('audience.session.index');
    }

    public function resendVerificationEmail($email)
    {
        $verificationData['email'] = $email;
        $verificationData['token'] = md5(uniqid(rand(), true));

        $audience = $this->audience->findOneByField('email', $email);

        $this->audience->update(['token' => $verificationData['token']], $audience->id);

        try {
            Mail::queue(new VerificationEmail($verificationData));

            if (Cookie::has('enable-resend')) {
                \Cookie::queue(\Cookie::forget('enable-resend'));
            }

            if (Cookie::has('email-for-resend')) {
                \Cookie::queue(\Cookie::forget('email-for-resend'));
            }
        } catch (\Exception $e) {
            session()->flash('error', trans('site::app.audience.signup-form.verification-not-sent'));

            return redirect()->back();
        }
        session()->flash('success', trans('site::app.audience.signup-form.verification-sent'));

        return redirect()->back();
    }
}
