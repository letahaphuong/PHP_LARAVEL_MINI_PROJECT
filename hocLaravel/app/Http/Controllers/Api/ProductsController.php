<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function __construct()
    {
    }

    public function getAllProducts()
    {
        return 'Lay tat ca san pham';
    }
}
