<?php

namespace App\Entities\Categories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Categories.
 *
 * @package namespace App\Entities\Categories;
 */
class Categories extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name'
    ];

}
