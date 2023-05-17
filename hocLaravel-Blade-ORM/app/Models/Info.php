<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Info extends Model
{
    protected $table = 'info';
    use HasFactory;

    public function user(): HasOne
    {
        return $this->hasOne(Users::class, 'user_id', 'id');
    }
}
