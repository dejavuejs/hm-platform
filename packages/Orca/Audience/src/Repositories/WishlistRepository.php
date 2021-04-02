<?php

namespace Orca\Audience\Repositories;

use Orca\Core\Eloquent\Repository;

/**
 * Wishlist Repisotory
 *
 * @author  Prashant Singh <>
 *
 */

class WishlistRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */

    function model()
    {
        return 'Orca\Audience\Contracts\Wishlist';
    }

    /**
     * @param array $data
     * @return mixed
     */

    public function create(array $data)
    {
        $wishlist = $this->model->create($data);

        return $wishlist;
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */

    public function update(array $data, $id, $attribute = "id")
    {
        $wishlist = $this->find($id);

        $wishlist->update($data);

        return $wishlist;
    }

    /**
     * To retrieve products with wishlist m
     * for a listing resource.
     *
     * @param integer $id
     */
    public function getItemsWithProducts($id) {
        return $this->model->find($id)->item_wishlist;
    }
}