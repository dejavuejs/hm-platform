<?php

namespace Orca\Audience\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * UserGroup Reposotory
 *
 * @author     <>
 *
 */

class UserGroupRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return 'Orca\Audience\Contracts\UserGroup';
    }

    /**
     * @param array $data
     * @return mixed
     */

    public function create(array $data)
    {
        $user = $this->model->create($data);

        return $user;
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */

    public function update(array $data, $id, $attribute = "id")
    {
        $user = $this->find($id);

        $user->update($data);

        return $user;
    }
}