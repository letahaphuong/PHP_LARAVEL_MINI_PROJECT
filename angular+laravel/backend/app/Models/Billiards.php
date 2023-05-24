<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billiards extends Model
{
    use HasFactory;

    protected $table = 'billiards';

    protected $fillable = [
        'id',
        'billiard_type_id',
        'start_time',
        'end_time',
        'status'
    ];

    public $timestamps = true;
}
