<?php

namespace App\Repositories\User;

use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\User\UserRepositoryRepository;
use App\Entities\User\UserRepository;
use App\Validators\User\UserRepositoryValidator;

/**
 * Class UserRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\User;
 */
class UserRepositoryRepositoryEloquent extends BaseRepository implements UserRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserRepository::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getAllUsers($table, $filters = [], $keywords = '', $sortByArr = [], $perPage = 0)
    {
        $orderBy = 'create_at';
        $orderType = 'desc';
        $users = DB::table($table)
            ->select('user.*', 'groups.name as group_name')
            ->join('groups', 'groups.id', '=', 'user.group_id')
            ->where('flag_delete', '=', 0);

        if (!empty($sortByArr) && is_array($sortByArr)) {
            if (!empty($sortByArr['sortBy']) && !empty($sortByArr['sortType'])) {
                $orderBy = trim($sortByArr['sortBy']);
                $orderType = trim($sortByArr['sortType']);
            }
        }
        $users = $users->orderBy('user.' . $orderBy, $orderType);

        if (!empty($filters)) {
            $users = $users->where($filters);
        }

        if (!empty($keywords)) {
            $users = $users->where(function ($query) use ($keywords) {
                $query->orWhere('fullname', 'like', '%' . $keywords . '%');
                $query->orWhere('email', 'like', '%' . $keywords . '%');
            });
        }

//        $users = $users->get();

        if (!empty($perPage)) {
            $users = $users->paginate($perPage)->withQueryString();
        } else {
            $users = $users->get();
        }

        return $users;
    }

    public function addUser($table, $data)
    {
        DB::enableQueryLog();

        if (!empty($data)) {
            $finalData = array_slice($data, 0, -1);
        }
        // Thêm dữ liệu (INSERT)
        return Users::create($finalData);
    }

    public function getDetail($table, $id)
    {
//        dd(Users::find($id));
        return DB::table($table)
            ->where('id', '=', $id)
            ->get();
//        return Users::find( $id);
    }

    public function updateUser($table, $data, $id)
    {
        $finalData = array_slice($data, 0, -1);
        return DB::table($table)
            ->where('id', '=', $id)
            ->update($finalData);
    }

    public function deleteUser($table, $id)
    {
        DB::enableQueryLog();

        return DB::table($table)
            ->where('id', '=', $id)
            ->update(['flag_delete' => 1]);
    }
}
