<?php

namespace Orca\Core\Repositories;

use Illuminate\Container\Container as App;
use Orca\Core\Eloquent\Repository;

/**
 * SubscribersList Repository
 *
 * @author    Prashant Singh <>
 *
 */
class SubscribersListRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\Core\Contracts\SubscribersList';
    }


    /**
     * Delete a slider item and delete the image from the disk or where ever it is
     *
     * @return Boolean
     */
    public function destroy($id) {
        return $this->model->destroy($id);
    }
}