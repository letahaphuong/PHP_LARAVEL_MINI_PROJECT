<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;

    private const TABLE = 'user';

    public function getAllUsers()
    {
        $users = DB::select('select * from ' . self::TABLE . ' order by create_at DESC ');
        return $users;
    }

    public function addUser($data)
    {
        $resultArray = array_slice($data, 0, -1);
        $columns = implode(',', array_keys($resultArray));
        $newValue = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($resultArray));

        $values = implode(",", $newValue);


        $query = 'insert into ' . self::TABLE . '(' . $columns . ') values (' . $values . ')';
//        dd($query);
        DB::insert($query);
//        DB::insert('insert into ' . self::TABLE . ' (fullname, email, create_at) values (?,?,?)', $data);
    }

    public function getDetail($id)
    {
        return DB::select('select * from ' . self::TABLE . ' where id = ?', [$id]);
    }

    public function updateUser($data, $id)
    {
        $dataSet = [];

        foreach ($data as $key => $value) {
            array_push($dataSet, "${key} = '" . $value . "'");
            $resultArray = array_slice($dataSet, 0, -1);
        }

        $columnValue = implode(',', $resultArray);
        return DB::update('update ' . self::TABLE . ' set ' . $columnValue . ' where id = ?', [$id]);
    }

    public function deleteUser($id)
    {
        return DB::delete('delete from ' . self::TABLE . ' where id = ?', [$id]);
    }


    public function statementUser($sql)
    {
        return DB::statement($sql)  ;
    }
}
