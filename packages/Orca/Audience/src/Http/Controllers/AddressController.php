<?php

namespace Orca\Audience\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Audience\Repositories\UserRepository;
use Orca\Audience\Repositories\UserAddressRepository;
use Auth;

/**
 * Address controlller for the user basically for the tasks of users which will
 * be done after user authenticastion.
 *
 * @author    Prashant Singh <>
 *
 */
class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    protected $user;

    protected $address;

    public function __construct(
        UserRepository $user,
        UserAddressRepository $address
    )
    {
        $this->middleware('user');

        $this->_config = request('_config');

        $this->user = auth()->guard('user')->user();

        $this->address = $address;
    }

    /**
     * Address Route index page
     *
     * @return view
     */
    public function index()
    {
        return view($this->_config['view'])->with('addresses', $this->user->addresses);
    }

    /**
     * Show the address create form
     *
     * @return view
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Create a new address for audience.
     *
     * @return view
     */
    public function store()
    {
        request()->merge(['address1' => implode(PHP_EOL, array_filter(request()->input('address1')))]);

        $data = collect(request()->input())->except('_token')->toArray();

        $this->validate(request(), [
            'address1' => 'string|required',
            'country' => 'string|required',
            'state' => 'string|required',
            'city' => 'string|required',
            'postcode' => 'required',
            'phone' => 'required'
        ]);

        $cust_id['user_id'] = $this->user->id;
        $data = array_merge($cust_id, $data);

        if ($this->user->addresses->count() == 0) {
            $data['default_address'] = 1;
        }

        if ($this->address->create($data)) {
            session()->flash('success', trans('site::app.audience.account.address.create.success'));

            return redirect()->route($this->_config['redirect']);
        } else {
            session()->flash('error', trans('site::app.audience.account.address.create.error'));

            return redirect()->back();
        }
    }

    /**
     * For editing the existing addresses of current logged in audience
     *
     * @return view
     */
    public function edit($id)
    {
        $address = $this->address->findOneWhere([
            'id' => $id,
            'audience_id' => auth()->guard('user')->user()->id
        ]);

        if (! $address)
            abort(404);

        return view($this->_config['view'], compact('address'));
    }

    /**
     * Edit's the premade resource of audience called
     * Address.
     *
     * @return redirect
     */
    public function update($id)
    {
        request()->merge(['address1' => implode(PHP_EOL, array_filter(request()->input('address1')))]);

        $this->validate(request(), [
            'address1' => 'string|required',
            'country' => 'string|required',
            'state' => 'string|required',
            'city' => 'string|required',
            'postcode' => 'required',
            'phone' => 'required'
        ]);

        $data = collect(request()->input())->except('_token')->toArray();

        $addresses = $this->user->addresses;

        foreach($addresses as $address) {
            if ($id == $address->id) {
                session()->flash('success', trans('site::app.audience.account.address.edit.success'));

                $this->address->update($data, $id);

                return redirect()->route('audience.address.index');
            }
        }

        session()->flash('warning', trans('site::app.security-warning'));

        return redirect()->route('audience.address.index');
    }

    /**
     * To change the default address or make the default address, by default when first address is created will be the default address
     *
     * @return Response
     */
    public function makeDefault($id)
    {
        if ($default = $this->user->default_address) {
            $this->address->find($default->id)->update(['default_address' => 0]);
        }

        if ($address = $this->address->find($id)) {
            $address->update(['default_address' => 1]);
        } else {
            session()->flash('success', trans('site::app.audience.account.address.index.default-delete'));
        }

        return redirect()->back();
    }

    /**
     * Delete address of the current audience
     *
     * @param integer $id
     *
     * @return response mixed
     */
    public function destroy($id)
    {
        $address = $this->address->findOneWhere([
            'id' => $id,
            'audience_id' => auth()->guard('user')->user()->id
        ]);

        if (! $address)
            abort(404);

        $this->address->delete($id);

        session()->flash('success', trans('site::app.audience.account.address.delete.success'));

        return redirect()->route('audience.address.index');
    }
}
