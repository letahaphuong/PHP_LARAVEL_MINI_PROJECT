<?php

namespace App\Repositories\Billiards;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BilliardsRepository.
 *
 * @package namespace App\Repositories\Billiards;
 */
interface BilliardsRepository extends RepositoryInterface
{
    function index();

    function store($data,$id);

    function getBilliardTable($id);
}
