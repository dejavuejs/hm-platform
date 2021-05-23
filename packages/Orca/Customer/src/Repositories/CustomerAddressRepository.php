<?php

namespace Orca\Customer\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * Customer Reposotory
 *
 * @author    Prashant Singh <>
 *
 */

class CustomerAddressRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return 'Orca\Customer\Contracts\CustomerAddress';
    }
}