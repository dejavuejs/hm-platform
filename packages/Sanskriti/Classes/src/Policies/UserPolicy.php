<?php

namespace ZapInv\User\Policies;

use App\Models\User;
use ZapInv\Authorization\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * User Policy class responsible user model access to screens and resources
 * Strictly to be applied for all routes which are authenticated.
 * For non-authenticated route this strictly should not be used.
 */
class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Before callback for policies
     */
    public function before(User $user)
    {
        $user->id === $user->team->owner_id;
    }

    /**
     * Policy object to be processed for reading model object
     *
     * @return void
     */
    public function view(User $user)
    {
        // dd('policy');
        return $user->id === $user->team->owner_id;
    }

    /**
     * Policy object to be processed for create method
     *
     * @return void
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Policy object to be processed for update method
     *
     * @return void
     */
    public function update(User $user)
    {
        return false;
    }

    /**
     * Policy object to be processed for delete method
     *
     * @return void
     */
    public function delete(User $user)
    {
        return false;
    }
}
