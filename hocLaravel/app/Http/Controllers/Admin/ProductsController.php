<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        // Sử dụng session để check login
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return __METHOD__;
    }

    /**
     * Show the form for creating a new resource.
     * Hiển thị form thêm sản phẩm(GET).
     */
    public function create()
    {
        return __METHOD__;
        //
    }

    /**
     * Store a newly created resource in storage.
     * Sử lý thêm sản phẩm (POST).
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * Lấy ra thông tin của 1 sản phẩm (GET).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Hiển thị form sửa sản phẩm (GET).
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Tiến hành sử lý sửa sản phẩm.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * Xóa sản phẩm.
     */
    public function destroy(string $id)
    {
        //
    }
}
