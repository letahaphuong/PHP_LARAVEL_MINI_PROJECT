<?php

namespace App\Repositories\BilliardDetails;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BilliardDetailRepository.
 *
 * @package namespace App\Repositories\BilliardDetails;
 */
interface BilliardDetailRepository extends RepositoryInterface
{
    function getBilliardDetail($id);

    function getListBilliardDetails($orderCode, $perpage);

    function deleteAttach($id);

    function checkExitsId($id);

    function getBilliardDetailForUpdateQuantity($id);

    function updatequantity($data);

}
