<?php

namespace Orca\User\Http\Controllers;

use Exception;
use Orca\User\Http\Requests\UserForm;
use Illuminate\Support\Facades\{ Event, Hash };
use Orca\User\Repositories\AdminRepository as Admin;
use Orca\User\Repositories\RoleRepository as Role;

/**
 * Admin user controller
 *
 * @author     <>
 *
 */
class UserController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * AdminRepository object
     *
     * @var array
     */
    protected $admin;

    /**
     * RoleRepository object
     *
     * @var array
     */
    protected $role;

    /**
     * Create a new controller instance.
     *
     * @param  \Orca\User\Repositories\AdminRepository  $admin
     * @param  \Orca\User\Repositories\RoleRepository  $role
     * @return void
     */
    public function __construct(Admin $admin, Role $role)
    {
        $this->admin = $admin;

        $this->role = $role;

        $this->_config = request('_config');

        $this->middleware('guest', ['except' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = $this->role->all();

        return view($this->_config['view'], compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Orca\User\Http\Requests\UserForm  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserForm $request)
    {
        $data = $request->all();

        if (isset($data['password']) && $data['password'])
            $data['password'] = bcrypt($data['password']);

        Event::dispatch('user.admin.create.before');

        $admin = $this->admin->create($data);

        Event::dispatch('user.admin.create.after', $admin);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'User']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->admin->findOrFail($id);

        $roles = $this->role->all();

        return view($this->_config['view'], compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Orca\User\Http\Requests\UserForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserForm $request, $id)
    {
        $data = $request->all();

        if (! $data['password'])
            unset($data['password']);
        else
            $data['password'] = bcrypt($data['password']);

        if (isset($data['status'])) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        Event::dispatch('user.admin.update.before', $id);

        $admin = $this->admin->update($data, $id);

        Event::dispatch('user.admin.update.after', $admin);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'User']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = $this->admin->findOrFail($id);

        if ($this->admin->count() == 1) {
            session()->flash('error', trans('admin::app.response.last-delete-error', ['name' => 'Admin']));
        } else {
            Event::dispatch('user.admin.delete.before', $id);

            if (auth()->guard('admin')->user()->id == $id) {
                return view('admin::customers.confirm-password');
            }

            try {
                $this->admin->delete($id);

                session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Admin']));

                Event::dispatch('user.admin.delete.after', $id);

                return response()->json(['message' => true], 200);
            } catch (Exception $e) {
                session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Admin']));
            }
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * destroy current after confirming
     *
     * @return mixed
     */
    public function destroySelf()
    {
        $password = request()->input('password');

        if (Hash::check($password, auth()->guard('admin')->user()->password)) {
            if ($this->admin->count() == 1) {
                session()->flash('error', trans('admin::app.users.users.delete-last'));
            } else {
                $id = auth()->guard('admin')->user()->id;

                Event::dispatch('user.admin.delete.before', $id);

                $this->admin->delete($id);

                Event::dispatch('user.admin.delete.after', $id);

                session()->flash('success', trans('admin::app.users.users.delete-success'));

                return redirect()->route('admin.session.create');
            }
        } else {
            session()->flash('warning', trans('admin::app.users.users.incorrect-password'));

            return redirect()->route($this->_config['redirect']);
        }
    }
}
