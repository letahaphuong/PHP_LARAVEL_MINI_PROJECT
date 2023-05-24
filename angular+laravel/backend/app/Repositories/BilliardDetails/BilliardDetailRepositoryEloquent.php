<?php

namespace App\Repositories\BilliardDetails;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BilliardDetails\BilliardDetailRepository;
use App\Entities\BilliardDetails\BilliardDetail;
use App\Validators\BilliardDetails\BilliardDetailValidator;

/**
 * Class BilliardDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories\BilliardDetails;
 */
class BilliardDetailRepositoryEloquent extends BaseRepository implements BilliardDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BilliardDetail::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    function getBilliardDetail($id)
    {
        return DB::table('billiard_details')
            ->where('attach_facility_id', '=', $id['attach_facility_id'])
            ->where('order_id', '=', $id['order_id'])
            ->where('code_order', '=', $id['code_order'])
            ->get()[0];
    }

    function getListBilliardDetails($orderCode, $perpage)
    {
        $getListAttach = DB::table('billiard_details as b')
            ->select('b.*', 'a.id as attachFacilityId', 'a.name', 'a.price')
            ->join('attach_facility as a', 'a.id', '=', 'b.attach_facility_id')
            ->where('b.code_order', '=', $orderCode);
        if (!empty($perpage)) {
            $getListAttach = $getListAttach->paginate($perpage)->withQueryString();
        } else {
            $getListAttach = $getListAttach->get();
        }

        return $getListAttach;
    }


    function deleteAttach($id)
    {
        $delete = DB::table('billiard_details')
            ->delete($id);
        return $delete;
    }

    function checkExitsId($id)
    {
        $boolean = DB::table('billiard_details')
            ->select('id')
            ->where('id', '=', $id)
            ->exists();
        return $boolean;
    }

    function getBilliardDetailForUpdateQuantity($id)
    {
        return DB::table('billiard_details')
            ->where('id', '=', $id)
            ->get();
    }

    function updatequantity($data)
    {
        return DB::table('billiard_details')
            ->where('id', '=', $data['id'])
            ->update(['quantity' => $data['quantity']]);
    }
}
