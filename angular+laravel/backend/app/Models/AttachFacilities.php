<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachFacilities extends Model
{
    use HasFactory;

    protected $table = 'attach_facility';

    protected $fillable = [
        'id',
        'category_id',
        'name',
        'price'
    ];
}
