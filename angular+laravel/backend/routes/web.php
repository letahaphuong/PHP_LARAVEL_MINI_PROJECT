<?php

use App\Http\Controllers\AttachFacilitiesController\ActtachFacilityController;
use App\Http\Controllers\BilliardsControllers\BilliardsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsManagementController\ProductManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::prefix('billiard')->name('billiard.')->group(function () {
    Route::get('home', [BilliardsController::class, 'home'])->name('home');
    Route::get('/', [BilliardsController::class, 'getAllTable'])->name('index');
    Route::get('start_billiard/{id}', [BilliardsController::class, 'getBilliardTable'])->name('get-table');
    Route::post('add_billiard', [BilliardsController::class, 'createBilliardTable'])->name('create-table');
    Route::get('end_billiard/{id}', [BilliardsController::class, 'getBilliardTableEnd'])->name('end-time');
    Route::post('end_billiard', [BilliardsController::class, 'endBilliardTable'])->name('end-table');
    Route::get('add', [ActtachFacilityController::class, 'showViewCreate'])->name('create');
    Route::get('add-category', [ActtachFacilityController::class, 'addFacilities'])->name('add-category');
    Route::get('delete_attach_detail/{id}', [BilliardsController::class, 'delete'])->name('delete-attach');
    Route::get('update_attach_detail', [BilliardsController::class, 'updateAttachDetails'])->name('update-attach');
    Route::get('show-products', [ProductManagementController::class, 'index'])->name('products-management');
    Route::post('add_new_billiard', [ProductManagementController::class, 'addNewBilliard'])->name('add-new-billiard');
    Route::post('edit_new_billiard', [ProductManagementController::class, 'editNewBilliard'])->name('edit-new-billiard');
    Route::post('add_new_billiard_type', [ProductManagementController::class, 'addNewBilliardType'])->name('add-new-billiard-type');
    Route::post('edit_new_billiard_type', [ProductManagementController::class, 'editNewBilliardType'])->name('edit-new-billiard-type');
    Route::get('delete_billiard_type/{id}', [ProductManagementController::class, 'deleteBilliardType'])->name('deleteB-billiardType');
    Route::post('add_product', [ProductManagementController::class, 'addProduct'])->name('add-new-product');
    Route::post('edit_product', [ProductManagementController::class, 'editProduct'])->name('edit-product');
    Route::get('delete_product/{id}', [ProductManagementController::class, 'deleteProduct'])->name('delete-product');
    Route::post('add_category', [ProductManagementController::class, 'addCategory'])->name('add-new-category');
    Route::post('edit_category', [ProductManagementController::class, 'editCategory'])->name('edit-category');
    Route::get('delete_category/{id}', [ProductManagementController::class, 'deleteCategory'])->name('delete-category');
    Route::get('dashboard', [ProductManagementController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard_details/{id}', [ProductManagementController::class, 'dashboardDetail'])->name('dashboard-details');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


