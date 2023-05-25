<?php

namespace App\Repositories\Facilities;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Facilities\AttachFacilityRepository;
use App\Entities\Facilities\AttachFacility;
use App\Validators\Facilities\AttachFacilityValidator;

/**
 * Class AttachFacilityRepositoryEloquent.
 *
 * @package namespace App\Repositories\Facilities;
 */
class AttachFacilityRepositoryEloquent extends BaseRepository implements AttachFacilityRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AttachFacility::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    function getAllAttachFacilities($filters, $keywords, $perPage)
    {
        DB::enableQueryLog();
        $categories = DB::table('attach_facility')
            ->select('attach_facility.id', 'attach_facility.category_id', 'attach_facility.name as attachFacilityName', 'attach_facility.price', 'categories.name as categoryName')
            ->join('categories', 'attach_facility.category_id', '=', 'categories.id')
            ->orderBy('attach_facility.category_id', 'desc')
            ->orderBy('attach_facility.id', 'desc');
        if (!empty($filters)) {
            $categories = $categories->where('attach_facility.category_id', '=', $filters);
        }
        if (!empty($keywords)) {
            $categories = $categories->where(function ($query) use ($keywords) {
                $query->orWhere('attach_facility.name', 'like', '%' . $keywords . '%');
                $query->orWhere('attach_facility.price', 'like', '%' . $keywords . '%');
            });
        }
        if (!empty($perPage)) {
            $categories = $categories->paginate($perPage)->withQueryString();
        } else {
            $categories = $categories->get();
        }
//        return DB::table('attach_facility')
//            ->where('category_id', '=', $category_id)
//            ->get();
//        $sql = DB::getQueryLog();
//        dd($sql);
        return $categories;
    }

    function createAttachFacility($data)
    {
        return DB::table('billiard_details')
            ->insert($data);
    }

    function updateAttachFacility($data)
    {
        return DB::table('billiard_details')
            ->where('id', '=', $data['id'])
            ->update($data);

    }

    function updateProductQuantity($data)
    {
        $query = DB::table('attach_facility')
            ->where('id', '=', $data['id'])
            ->update($data);

        return $query;
    }

    function getProductByIdAttachFacility($idAttachFacility)
    {
        $query = DB::table('attach_facility')
            ->find($idAttachFacility);

        return $query;
    }
}
