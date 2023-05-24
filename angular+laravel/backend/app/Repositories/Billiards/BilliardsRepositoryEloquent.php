<?php

namespace App\Repositories\Billiards;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Billiards\BilliardsRepository;
use App\Entities\Billiards\Billiards;
use App\Validators\Billiards\BilliardsValidator;

/**
 * Class BilliardsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Billiards;
 */
class BilliardsRepositoryEloquent extends BaseRepository implements BilliardsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Billiards::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    function index()
    {
        return Billiards::all();
    }

    function store($data,$id)
    {
//        if (!empty($data)) {
//            $insertData = array_slice($data, 0, -1);
//        }
        return DB::table('billiards')
            ->where('id', '=', $id)
            ->update($data);
    }

    function getBilliardTable($id)
    {
        return Billiards::find($id);
    }
}
