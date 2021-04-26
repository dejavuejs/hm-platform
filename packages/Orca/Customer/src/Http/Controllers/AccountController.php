<?php

namespace Orca\Customer\Http\Controllers;

use Orca\Customer\Repositories\UserRepository;
use Orca\Customer\Repositories\UserAddressRepository;
use Auth;

/**
 * Account Controlller for the Customers
 * basically will control the landing
 * behavior for custome and group of
 * Customers.
 *
 * @author    Prashant Singh <>
 *
 */
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;
    protected $customer;
    protected $address;


    public function __construct(UserRepository $customer, UserAddressRepository $address)
    {
        $this->middleware('customer');

        $this->_config = request('_config');

        $this->customer = $customer;

        $this->address = $address;
    }

    public function index() {
        return view($this->_config['view']);
    }
}
