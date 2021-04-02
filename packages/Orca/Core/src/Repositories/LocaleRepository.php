<?php

namespace Orca\Core\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * Locale Reposotory
 *
 * @author     <>
 *
 */
class LocaleRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\Core\Contracts\Locale';
    }
}