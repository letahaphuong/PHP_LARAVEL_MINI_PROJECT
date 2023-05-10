<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\u;

class Users extends Model
{
    use HasFactory;

    private const TABLE = 'user';

    public function getAllUsers($filters = [], $keywords = '', $sortByArr = [], $perPage = 0)
    {
        DB::enableQueryLog();

        $users = DB::table(self::TABLE)
            ->select('user.*', 'groups.name as group_name')
            ->join('groups', 'groups.id', '=', 'user.group_id')
            ->where('flag_delete', '=', 0);
        $orderBy = 'create_at';
        $orderType = 'desc';

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

    public function addUser($data)
    {
        DB::enableQueryLog();

        if (!empty($data)) {
            $finalData = array_slice($data, 0, -1);
        }
        // Thêm dữ liệu (INSERT)
        return DB::table(self::TABLE)->insert($finalData);
    }

    public function getDetail($id)
    {
//        return DB::select('select * from ' . self::TABLE . ' where id = ?', [$id]);
        return DB::table(self::TABLE)
            ->where('id', '=', $id)
            ->get();
    }

    public function updateUser($data, $id)
    {
        $finalData = array_slice($data, 0, -1);
        return DB::table(self::TABLE)
            ->where('id', '=', $id)
            ->update($finalData);

    }

    public function deleteUser($id)
    {
        DB::enableQueryLog();

        return DB::table(self::TABLE)
            ->where('id', '=', $id)
            ->update(['flag_delete' => 1]);
    }


    public function statementUser($sql)
    {
        return DB::statement($sql);
    }

    /**
     * Thuc hanh queryBuilder
     * @return void
     */
    public function learnQueryBuilder()
    {
        // Cách xem câu query
        DB::enableQueryLog();
        $titles = DB::table('user')->pluck('fullname');

        foreach ($titles as $name) {
            echo $name . '<br/>';
        }

        // Lây tất cả bản ghi của table.
        $list = DB::table(self::TABLE)
//            ->get();
            ->find(1);

        // Lấy 1 bản ghi đầu tiên của table.(lấy thông tin chi tiết)
        $detail = DB::table(self::TABLE)
            ->where('fullname', 'like', '%Nguyen Thi Cam%')
//            ->first();
            ->value('email');
        // Lấy theo cột trong bản
        $listByCoulumn = DB::table(self::TABLE)->select('fullname', 'email')->count();
//        $count = count($listByCoulumn);
        // Truy vấn theo điều kiện where
        $findByID = DB::table(self::TABLE)
//            ->where('fullname', 'like', '%Nguyen Thi Cam Van%')
            ->where('id', '>', 3)
            ->get();

        // Truy vấn với điều kiện khách (<>);
        $khac = DB::table(self::TABLE)
            ->select('id', 'email', 'fullname as tendaydu')
            ->where('id', '<>', '9')
            ->get();

        // Truy vấn kết hợp AND
        $andOr = DB::table(self::TABLE)
            ->select('email', 'id', 'fullname')
//            ->where('id','>',2) // Cách 1;
//            ->where('id','<',11) // Cách 1;
            ->where([ // Cách 2
                ['id', '>', 2],
                ['id', '<', 11]
            ])
            ->get();

        // Truy vấn kết hợp OR
        $orWhere = DB::table(self::TABLE)
            ->select('email', 'id', 'fullname')
            ->where('id', '=', '1')
            ->orWhere('fullname', '=', 'Nguyen1 Thi Cam Van')
//            ->toSql();
            ->get();

        // Truy vấn kết hợp điều kiện nâng cao.
        $id = 11;
        $condition = DB::table(self::TABLE)
            ->select('*')
            ->where('id', '=', 9)
            ->where(function ($query) use ($id) {
                $query->where('id', '<', $id)->orwhere('id', '>', $id);
            })
            ->get();

        // Tìm kím mệnh đề like
        $name = 'Nguyen Thi Cam';
        $findByName = DB::table(self::TABLE)
            ->select('*')
            ->where('fullname', 'like', '%' . $name . '%')
            ->get();

        // Truy vấn lấy giá trị trong khoản between
        $between = DB::table(self::TABLE)
            ->select('*')
            ->whereBetween('id', [2, 11])
            ->get();

        // Truy vấn lấy giá trị nằm ngoài khoản
        $notBetween = DB::table(self::TABLE)
            ->select('*')
            ->whereNotBetween('id', [2, 11])
            ->get();

        // Truy vấn với where in {LẤY PHẦN TỬ THUỘC TRONG CÁI MẢNG GIÁ TRỊ}
        $whereIn = DB::table(self::TABLE)
            ->select('*')
            ->whereNotIn('id', [2, 11])
            ->get();

        // Truy vấn với where null(NOT NULL)
        $null = DB::table(self::TABLE)
            ->select('*')
            ->whereNull('create_at')
            ->get();
//        dd($null);

        // Truy vấn Date(whereDate)
        $date = DB::table('user')
            ->whereDate('create_at', '2023-05-08')
            ->get();

        // Truy vấn theo tháng(whereMonth)
        $month = DB::table('user')
            ->whereYear('create_at', '2023')
            ->get();

        // So sánh 2 cột bằng nhau
        $column = DB::table('user')
            ->whereColumn('create_at', '<>', 'update_at')
            ->get();

        // Join bản trong queryBuilder
        $var = 'rightJoin';
        $join = DB::table('user')
            ->select('user.*', 'groups.name')
            ->$var('groups', 'groups.id', '=', 'user.group_id')
            ->where('groups.name', '=', 'Admin')
            ->get();

        // Sắp xếp (orderBy)
        $join1 = DB::table(self::TABLE)
            ->select('*')
            ->orderBy('create_at', 'desc')
            ->orderBy('id', 'asc')
//            ->inRandomOrder()
            ->get();

        // Group by
        $groupBy = DB::table(self::TABLE)
            ->select(DB::raw('count(id) as count_email'), 'email')
            ->groupBy('email')
            ->having('email', '=', 'nguyenthicamvan@gmail.com')
            ->get();

        // giới hạn OFFET vs LIMIT
        $limit = DB::table(self::TABLE)
            ->take(2)
            ->skip(4)
            ->get();

        // Thêm dữ liệu (INSERT)
//       DB::table(self::TABLE)->insert([
//            'fullname' => 'Trần Thanh Huy',
//            'email' => 'gynoroku@gmail.com',
//            'group_id' => 3
//        ]);

//       DB::getPdo()->lastInsertId(); // C1
//        $lastId = DB::table(self::TABLE)->insertGetId([ // Cach 2 get last ID
//            'fullname' => 'Trần Thanh Huy',
//            'email' => 'gynoroku@gmail.com',
//            'group_id' => 3
//        ]);

        // Sửa dữ liệu (UPDATE)
//        DB::table(self::TABLE)
//            ->where('id' ,'=', 9)
//            ->update([
//                'fullname' => 'FA RIN NE',
//                'email' => 'dinhthanhfarin@gmail.com'
//            ]);

        // Xóa dữ liệu
        DB::table(self::TABLE)
            ->where('id', '=', 9)
            ->delete();

        // DB::raw()
        $user = DB::table(self::TABLE)
            ->select(DB::raw('sum(id) as count_id'), 'email',)
            ->groupBy('email')
            ->having('email', '=', "nguyenthicamvan@gmail.com")
            ->get();
        // selectRaw()
        $user1 = DB::table(self::TABLE)
            ->selectRaw('fullname, email , count(id)')
            ->groupBy(['email', 'fullname'])
            ->get();

        // whereRaw() and orWhereRaw()
        $user2 = DB::table(self::TABLE)
            ->selectRaw('fullname,email')
            ->whereRaw('id > ?', [12])
            ->get();

        // orderByRaw()
        $user2 = DB::table(self::TABLE)
            ->selectRaw('fullname,email')
            ->orderByRaw('create_at DESC, update_at ASC')
            ->get();

        // groupByRaw()
        $user2 = DB::table(self::TABLE)
            ->selectRaw('count(id),email')
            ->groupByRaw('email')
            ->get();

        // havingRaw()
        $user2 = DB::table(self::TABLE)
            ->selectRaw('email')
            ->groupBy('email')
            ->havingRaw('count(email) >= ?', [2])
            ->get();

        // subQuery
        $user3 = DB::table(self::TABLE)
//            ->where(
//                'group_id',
//                '=',
//                function ($query) {
//                    $query->select('id')->from('groups')->where('name', '=', 'Admin');
//                }
//            )
//            ->select('email', DB::raw('(select count(id) from `groups`) as groups_count')) // C1
            ->selectRaw('email,(select count(id) from `groups`) as groups_count')
            ->get();

        dd($user3);
        $sql = DB::getQueryLog();
        dd($sql);
    }
}
