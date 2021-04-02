<?php

namespace Orca\User\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * Role Reposotory
 *
 * @author     <>
 *
 */
class RoleRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\User\Contracts\Role';
    }
}