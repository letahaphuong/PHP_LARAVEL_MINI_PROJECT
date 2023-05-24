<?php

namespace App\Entities\Facilities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AttachFacility.
 *
 * @package namespace App\Entities\Facilities;
 */
class AttachFacility extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'attach_facility';
    protected $fillable = [

    ];

}
