<?php

namespace Orca\Audience\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Audience\Repositories\AudienceRepository;
use Orca\Product\Repositories\ProductReviewRepository as ProductReview;
use Orca\Audience\Models\User;
use Auth;
use Hash;

/**
 * Audience controlller for the audience basically for the tasks of audiences which will be
 * done after audience authentication.
 *
 * @author  Prashant Singh <>
 *
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * AudienceRepository object
     *
     * @var array
    */
    protected $audience;

    /**
     * ProductReviewRepository object
     *
     * @var array
    */
    protected $productReview;

    /**
     * Create a new Repository instance.
     *
     * @param  \Orca\Audience\Repositories\AudienceRepository     $audience
     * @param  \Orca\Product\Repositories\ProductReviewRepository $productReview
     * @return void
    */
    public function __construct(
        AudienceRepository $audience,
        ProductReview $productReview
    )
    {
        $this->middleware('audience');

        $this->_config = request('_config');

        $this->audience = $audience;

        $this->productReview = $productReview;
    }

    /**
     * Taking the audience to profile details page
     *
     * @return View
     */
    public function index()
    {
        $audience = $this->audience->find(auth()->guard('audience')->user()->id);

        return view($this->_config['view'], compact('audience'));
    }

    /**
     * For loading the edit form page.
     *
     * @return View
     */
    public function edit()
    {
        $audience = $this->audience->find(auth()->guard('audience')->user()->id);

        return view($this->_config['view'], compact('audience'));
    }

    /**
     * Edit function for editing audience profile.
     *
     * @return Redirect.
     */
    public function update()
    {
        $id = auth()->guard('audience')->user()->id;

        $this->validate(request(), [
            'first_name' => 'string',
            'last_name' => 'string',
            'gender' => 'required',
            'date_of_birth' => 'date|before:today',
            'email' => 'email|unique:audiences,email,'.$id,
            'oldpassword' => 'required_with:password',
            'password' => 'confirmed|min:6'
        ]);

        $data = collect(request()->input())->except('_token')->toArray();

        if ($data['date_of_birth'] == "") {
            unset($data['date_of_birth']);
        }

        if ($data['oldpassword'] != "" || $data['oldpassword'] != null) {
            if(Hash::check($data['oldpassword'], auth()->guard('audience')->user()->password)) {
                $data['password'] = bcrypt($data['password']);
            } else {
                session()->flash('warning', trans('site::app.audience.account.profile.unmatch'));

                return redirect()->back();
            }
        } else {
            unset($data['password']);
        }

        if ($this->audience->update($data, $id)) {
            Session()->flash('success', trans('site::app.audience.account.profile.edit-success'));

            return redirect()->route($this->_config['redirect']);
        } else {
            Session()->flash('success', trans('site::app.audience.account.profile.edit-fail'));

            return redirect()->back($this->_config['redirect']);
        }
    }

    /**
     * Load the view for the audience account panel, showing approved reviews.
     *
     * @return Mixed
     */
    public function reviews()
    {
        $reviews = auth()->guard('audience')->user()->all_reviews;

        return view($this->_config['view'], compact('reviews'));
    }
}
