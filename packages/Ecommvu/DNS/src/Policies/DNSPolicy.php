<?php

namespace Ecommvu\DNS\Policies;

use Ecommvu\AppStore\Facades\AppStore;
use Ecommvu\AppStore\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * DNS Policy class responsible DNS model object access for checking basis of scopes
 */
class DNSPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Before method declaration for license
     *
     * @var Object||NULL
     */
    // public function before(\Ecommvu\AppStore\Contracts\AdminInterface $admin)
    // {
    //     $adminRole = $admin->role->where([
    //         'permission_type' => 'all'
    //     ])->OrWhere([
    //         'permission_type' => '*'
    //     ])->get();

    //     if ($adminRole->count()) {
    //         return true;
    //     }
    // }

    /**
     * Policy object to be processed for reading model object
     *
     * @param \App\AppStore\Contracts\AdminInterface $admin
     * @return void
     */
    public function view(\Ecommvu\AppStore\Contracts\AdminInterface $admin)
    {
        dd('ss');
        $admin = $admin->where([
            'permission_type' => 'dns.view'
        ])->orWhere([
            'permission_type' => 'all'
        ])->get();

        if ($admin->count()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Policy object to be processed for create method
     *
     * @param \App\AppStore\Contracts\AdminInterface $admin
     * @return void
     */
    public function create(\Ecommvu\AppStore\Contracts\AdminInterface $admin)
    {
        $adminRole = $admin->where([
            'permission_type' => 'dns.create'
        ])->orWhere([
            'permission_type' => 'all'
        ])->get();

        if ($adminRole->count()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Policy object to be processed for update method
     *
     * @param \App\AppStore\Contracts\AdminInterface $admin
     * @return void
     */
    public function update(\Ecommvu\AppStore\Contracts\AdminInterface $admin)
    {
        $adminRole = $admin->where([
            'permission_type' => 'dns.update'
        ])->orWhere([
            'permission_type' => 'all'
        ])->get();

        if ($adminRole->count()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Policy object to be processed for delete method
     *
     * @param \App\AppStore\Contracts\AdminInterface $admin
     * @return void
     */
    public function delete(\Ecommvu\AppStore\Contracts\AdminInterface $admin)
    {
        $adminRole = $admin->where([
            'permission_type' => 'dns.destroy'
        ])->orWhere([
            'permission_type' => 'all'
        ])->get();

        if ($adminRole->count()) {
            return true;
        } else {
            return false;
        }
    }
}