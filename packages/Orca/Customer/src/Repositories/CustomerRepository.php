<?php

namespace Orca\Customer\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * User Reposotory
 *
 * @author    Prashant Singh <>
 *
 */
class CustomerRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return 'Orca\Customer\Contracts\Customer';
    }
}