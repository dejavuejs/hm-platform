<?php

namespace Ecommvu\Marketing\Repositories;

use Orca\Core\Eloquent\Repository;

class TemplateRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Ecommvu\Marketing\Contracts\Template';
    }
}