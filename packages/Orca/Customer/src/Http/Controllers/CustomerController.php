<?php

namespace Orca\Customer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Customer\Repositories\CustomerRepository;
use Orca\Product\Repositories\ProductReviewRepository as ProductReview;
use Orca\Customer\Models\Customer;
use Auth;
use Hash;

/**
 * Customer controlller for the customer basically for the tasks of customers which will be
 * done after customer authentication.
 *
 * @author  Prashant Singh <>
 *
 */
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * CustomerRepository object
     *
     * @var array
    */
    protected $customer;

    /**
     * ProductReviewRepository object
     *
     * @var array
    */
    protected $productReview;

    /**
     * Create a new Repository instance.
     *
     * @param  \Orca\Customer\Repositories\CustomerRepository     $customer
     * @param  \Orca\Product\Repositories\ProductReviewRepository $productReview
     * @return void
    */
    public function __construct(
        CustomerRepository $customer,
        ProductReview $productReview
    )
    {
        $this->middleware('customer');

        $this->_config = request('_config');

        $this->customer = $customer;

        $this->productReview = $productReview;
    }

    /**
     * Taking the customer to profile details page
     *
     * @return View
     */
    public function index()
    {
        $customer = $this->customer->find(auth()->guard('customer')->customer()->id);

        return view($this->_config['view'], compact('customer'));
    }

    /**
     * For loading the edit form page.
     *
     * @return View
     */
    public function edit()
    {
        $customer = $this->customer->find(auth()->guard('customer')->customer()->id);

        return view($this->_config['view'], compact('customer'));
    }

    /**
     * Edit function for editing customer profile.
     *
     * @return Redirect.
     */
    public function update()
    {
        $id = auth()->guard('customer')->customer()->id;

        $this->validate(request(), [
            'first_name' => 'string',
            'last_name' => 'string',
            'gender' => 'required',
            'date_of_birth' => 'date|before:today',
            'email' => 'email|unique:customers,email,'.$id,
            'oldpassword' => 'required_with:password',
            'password' => 'confirmed|min:6'
        ]);

        $data = collect(request()->input())->except('_token')->toArray();

        if ($data['date_of_birth'] == "") {
            unset($data['date_of_birth']);
        }

        if ($data['oldpassword'] != "" || $data['oldpassword'] != null) {
            if(Hash::check($data['oldpassword'], auth()->guard('customer')->customer()->password)) {
                $data['password'] = bcrypt($data['password']);
            } else {
                session()->flash('warning', trans('site::app.customer.account.profile.unmatch'));

                return redirect()->back();
            }
        } else {
            unset($data['password']);
        }

        if ($this->customer->update($data, $id)) {
            Session()->flash('success', trans('site::app.customer.account.profile.edit-success'));

            return redirect()->route($this->_config['redirect']);
        } else {
            Session()->flash('success', trans('site::app.customer.account.profile.edit-fail'));

            return redirect()->back($this->_config['redirect']);
        }
    }

    /**
     * Load the view for the customer account panel, showing approved reviews.
     *
     * @return Mixed
     */
    public function reviews()
    {
        $reviews = auth()->guard('customer')->customer()->all_reviews;

        return view($this->_config['view'], compact('reviews'));
    }
}
