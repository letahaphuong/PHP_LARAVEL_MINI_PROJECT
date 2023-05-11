<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Groups extends Model
{
    use HasFactory;

    private const TABLE = 'groups';

    public function getAll(){
        $groups = DB::table(self::TABLE)
            ->orderBy('name','asc')
            ->get();
        return $groups;
    }
}
