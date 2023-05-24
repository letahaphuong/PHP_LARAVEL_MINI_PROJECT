<?php

namespace App\Repositories\Orders;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository.
 *
 * @package namespace App\Repositories\Orders;
 */
interface OrderRepository extends RepositoryInterface
{
    function createOrder($data);

    function findOrderById($id);

    function getCodeBilliard($id);
}
