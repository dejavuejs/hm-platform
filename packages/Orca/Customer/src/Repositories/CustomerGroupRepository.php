<?php

namespace Orca\Customer\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * UserGroup Reposotory
 *
 * @author     <>
 *
 */

class CustomerGroupRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return 'Orca\Customer\Contracts\CustomerGroup';
    }

    /**
     * @param array $data
     * @return mixed
     */

    public function create(array $data)
    {
        $customer = $this->model->create($data);

        return $customer;
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */

    public function update(array $data, $id, $attribute = "id")
    {
        $customer = $this->find($id);

        $customer->update($data);

        return $customer;
    }
}