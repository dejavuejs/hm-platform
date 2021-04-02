<?php

namespace Orca\Core\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * Country Reposotory
 *
 * @author     <>
 *
 */
class CountryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\Core\Contracts\Country';
    }
}