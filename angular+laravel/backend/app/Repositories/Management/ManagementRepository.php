<?php

namespace App\Repositories\Management;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ManagementRepository.
 *
 * @package namespace App\Repositories\Management;
 */
interface ManagementRepository extends RepositoryInterface
{
    function showList($table, $select = ['*'], $perPage);

    function createObject($table, $data);

    function editObject($table, $data);

    function deleteObject($table, $id);

    function checkExit($table, $id);

    function historyList($table, $select = ['*'], $codeOrder);

    function listOrder($table, $select = ['*'],$perPage);

}
