<?php

namespace App\Repositories\User;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepositoryRepository.
 *
 * @package namespace App\Repositories\User;
 */
interface UserRepositoryRepository extends RepositoryInterface
{
    public function getAllUsers($table, $filters = [], $keywords = '', $sortByArr = [], $perPage = 0);

    public function addUser($table, $data);

    public function getDetail($table, $id);

    public function updateUser($table,$data, $id);

    public function deleteUser($table,$id);

}
