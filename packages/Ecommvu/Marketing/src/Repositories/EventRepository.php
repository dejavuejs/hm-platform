<?php

namespace Ecommvu\Marketing\Repositories;

use Ecommvu\Core\Eloquent\Repository;

class EventRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Ecommvu\Marketing\Contracts\Event';
    }
}