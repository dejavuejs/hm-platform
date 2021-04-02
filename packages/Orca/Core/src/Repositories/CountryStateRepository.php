<?php

namespace Orca\Core\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * CountryState Reposotory
 *
 * @author     <>
 *
 */
class CountryStateRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\Core\Contracts\CountryState';
    }
}