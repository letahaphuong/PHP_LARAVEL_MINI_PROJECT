<?php

namespace App\Repositories\Orders;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Orders\OrderRepository;
use App\Entities\Orders\Order;
use App\Validators\Orders\OrderValidator;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories\Orders;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    function createOrder($data)
    {
        return Order::create($data);
    }

    function findOrderById($id)
    {
        return DB::table('order')
            ->where('billiard_id', '=', $id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get()[0];
    }

    function getCodeBilliard($id)
    {
        return DB::table('order')
            ->select('code_billiard')
            ->orderBy('id', 'desc')
            ->where('billiard_id', '=', $id)
            ->limit(1)
            ->get()[0];
    }
}
