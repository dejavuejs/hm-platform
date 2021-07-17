<?php

namespace Ecommvu\Authorization\Policies;

use App\Models\User;

/**
 * AppStore Base Policy for Gates authorization
 */
abstract class BasePolicy
{
    /**
     * Meant for controller's index functions or route closures for datatables
     *
     * @return void
     */
    abstract public function view(User $user);

    /**
     * Meant for creation of resources
     *
     * @return void
     */
    abstract public function create(User $user);

    /**
     * Meant for updating resources
     *
     * @return void
     */
    abstract public function update(User $user);

    /**
     * Meant to delete or soft delete resources
     *
     * @return void
     */
    abstract public function delete(User $user);
}
