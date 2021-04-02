<?php

namespace Orca\Audience\Http\Controllers;

use Orca\Audience\Repositories\UserRepository;
use Orca\Audience\Repositories\UserAddressRepository;
use Auth;

/**
 * Account Controlller for the audiences
 * basically will control the landing
 * behavior for custome and group of
 * audiences.
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
    protected $user;
    protected $address;


    public function __construct(UserRepository $user, UserAddressRepository $address)
    {
        $this->middleware('user');

        $this->_config = request('_config');

        $this->user = $user;

        $this->address = $address;
    }

    public function index() {
        return view($this->_config['view']);
    }
}
