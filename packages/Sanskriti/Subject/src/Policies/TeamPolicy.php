<?php

namespace ZapInv\User\Policies;

use App\Models\User;
use App\Models\Team;
use Ecommvu\AppStore\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * User Policy class responsible user model access to screens and resources
 * Strictly to be applied for all routes which are authenticated.
 * For non-authenticated route this strictly should not be used.
 */
class TeamPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Policy object to be processed for reading model object
     *
     * @return void
     */
    public function view(User $user, Team $team)
    {
        return $user->id === $team->owner_id;
    }

    /**
     * Policy object to be processed for create method
     *
     * @return void
     */
    public function create()
    {
        return false;
    }

    /**
     * Policy object to be processed for update method
     *
     * @return void
     */
    public function update()
    {
        return false;
    }

    /**
     * Policy object to be processed for delete method
     *
     * @return void
     */
    public function delete()
    {
        return false;
    }
}
