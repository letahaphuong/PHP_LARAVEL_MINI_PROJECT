<?php

namespace App\Repositories\Categories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Categories\CategoriesRepository;
use App\Entities\Categories\Categories;
use App\Validators\Categories\CategoriesValidator;

/**
 * Class CategoriesRepositoryEloquent.
 *
 * @package namespace App\Repositories\Categories;
 */
class CategoriesRepositoryEloquent extends BaseRepository implements CategoriesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Categories::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    function getAllCategories()
    {
        return Categories::all();
    }
}
