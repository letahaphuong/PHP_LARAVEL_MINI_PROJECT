<?php

namespace App\Repositories\Categories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoriesRepository.
 *
 * @package namespace App\Repositories\Categories;
 */
interface CategoriesRepository extends RepositoryInterface
{
    function getAllCategories();
}
