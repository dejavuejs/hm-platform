<?php

namespace Orca\User\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * Admin Reposotory
 *
 * @author     <>
 *
 */
class AdminRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\User\Contracts\Admin';
    }
}