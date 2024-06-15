<?php

namespace Ecommvu\Transcriber\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * TranscriberRepository
 */
class TranscriptionJobRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Ecommvu\Transcriber\Contracts\TranscriptionJob';
    }
}