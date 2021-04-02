<?php

namespace Orca\Audience\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * User Reposotory
 *
 * @author    Prashant Singh <>
 *
 */

class UserAddressRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return 'Orca\Audience\Contracts\UserAddress';
    }
}