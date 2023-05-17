<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Quy ước tên TABLE
     * Tên model :Post => table:posts
     * Tên model : ProductCategory => table:product_categories
     */

    protected $table = 'posts';

    /**
     * @var string
     * Quy ước kháo chính, mặc định laravel sẽ lấy field "id" làm khóa chính
     */
    protected $primaryKey = 'id';

    public $timestamps = false;
    /**
     * Đổi tên 2 trường timetamps
     */
    const CREATED_AT = 'ten_truong_moi';
    const UPDATED_AT = 'ten_truong_moi';

    /**
     * set giá trị mặc định cho thuộc tính
     */
    protected $attributes = [
        'status' => 1
    ];

    protected $fillable = ['title','content','status'];
}
