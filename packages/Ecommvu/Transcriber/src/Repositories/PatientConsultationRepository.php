<?php

namespace Ecommvu\Transcriber\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * TranscriberRepository
 */
class PatientConsultationRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Ecommvu\Transcriber\Contracts\PatientConsultation';
    }
}