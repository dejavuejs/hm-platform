<?php

namespace Ecommvu\Transcriber\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * TranscriberRepository
 */
class TranscriberRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Ecommvu\Transcriber\Contracts\Admin';
    }
}