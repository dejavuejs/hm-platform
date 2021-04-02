<?php

namespace Orca\Core\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * Currency Reposotory
 *
 * @author     <>
 *
 */
class CurrencyRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\Core\Contracts\Currency';
    }

    public function delete($id) {
        if ($this->model->count() == 1) {
            return false;
        } else {
            if ($this->model->destroy($id)) {
                return true;
            } else {
                return false;
            }

        }
    }
}