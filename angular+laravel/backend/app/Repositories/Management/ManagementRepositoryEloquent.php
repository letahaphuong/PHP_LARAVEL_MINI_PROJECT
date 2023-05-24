<?php

namespace App\Repositories\Management;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Management\ManagementRepository;
use App\Entities\Management\Management;
use App\Validators\Management\ManagementValidator;

/**
 * Class ManagementRepositoryEloquent.
 *
 * @package namespace App\Repositories\Management;
 */
class ManagementRepositoryEloquent extends BaseRepository implements ManagementRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Management::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    function showList($table, $select = ['*'], $perPage)
    {
        DB::enableQueryLog();
//        $columns = array_map(function ($value) {
//            return "'" . $value . "'";
//        }, array_values($select));

        $newColumns = implode(",", $select);

        $query = DB::table($table)
            ->select(DB::raw($newColumns));
        if (!empty($perPage)) {
            $query = $query->paginate($perPage)->withQueryString();
        } else {
            $query = $query->get();
        }
        return $query;
    }

    function createObject($table, $data)
    {
//        dd($table,$data);
        return DB::table($table)
            ->insert($data);
    }

    function editObject($table, $data)
    {
//        dd($table,$data);
        return DB::table($table)
            ->where('id', '=', $data['id'])
            ->update($data);
    }

    function deleteObject($table, $id)
    {
        return DB::table($table, $id)
            ->delete($id);
    }

    function checkExit($table, $id)
    {
        return DB::table($table)
            ->select('id')
            ->where('id', '=', $id)
            ->exists();
    }

    function historyList($table, $select = ['*'], $codeOrder)
    {
        DB::enableQueryLog();
        $newColumns = implode(",", $select);
        $query = DB::table($table)
            ->select(DB::raw($newColumns))
            ->join('order', 'order.id', '=', $table . '.' . 'order_id')
            ->join('attach_facility', 'attach_facility.id', '=', $table . '.' . 'attach_facility_id')
            ->join('categories', 'categories.id', '=', 'attach_facility.' . 'category_id')
            ->join('billiards', 'billiards.id', '=', 'order.' . 'billiard_id')
            ->join('billiards_type', 'billiards_type.id', '=', 'billiards.' . 'billiard_type_id');

        if (!empty($codeOrder)) {
            $query = $query->where($table . '.code_order', '=', $codeOrder);
        }
        $query = $query->get();
//        $sql = DB::getQueryLog();
//        dd($sql);
        return $query;
    }

    function listOrder($table, $select = ['*'], $perPage)
    {
        $newColumns = implode(",", $select);
        $query = DB::table($table)
            ->select(DB::raw($newColumns))
            ->orderBy('created_at', 'desc');
        if (!empty($perPage)) {
            $query = $query->paginate($perPage)->withQueryString();
        } else {
            $query = $query->get();
        }
        return $query;
    }
}
