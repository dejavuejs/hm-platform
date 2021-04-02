<?php

namespace Orca\Core\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * ExchangeRate Reposotory
 *
 * @author     <>
 *
 */
class ExchangeRateRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\Core\Contracts\CurrencyExchangeRate';
    }
}