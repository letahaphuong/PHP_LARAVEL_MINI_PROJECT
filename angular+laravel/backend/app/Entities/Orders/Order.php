<?php

namespace App\Entities\Orders;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Order.
 *
 * @package namespace App\Entities\Orders;
 */
class Order extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'order';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'billiard_id',
        'code_billiard'
    ];

}
