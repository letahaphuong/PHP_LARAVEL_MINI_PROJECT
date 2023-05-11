<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('products', [HomeController::class, 'products'])->name('product');

Route::get('/add', [HomeController::class, 'showFormCreate']);

Route::post('/add', [HomeController::class, 'createProduct'])->name('post-add');

//Route::put('/add', [HomeController::class, 'putAdd']);

Route::get('demo-res', function () {
    return view('clients.demo-test');
//    return '<h2>Welcome to unicode</h2>';
})->name('demo');

Route::post('demo-res', function (Request $request) {
    if (!empty($request->username)) {
//        return redirect(route('demo'))->with(['mess' => 'Thanh cong', 'type' => 'success']);
        return back()->withInput()->with(['mess' => 'Thanh cong', 'type' => 'success']);
    }
    return redirect(route('demo'))->with(['mess' => 'Khong thanh cong', 'type' => 'danger']);

});

Route::get('demo-res-2', function (Request $request) {
    return $request->cookie('unicode');
});

Route::get('get-array', [HomeController::class, 'getArray']);
Route::get('demo', [HomeController::class, 'demo']);
Route::post('demo', [HomeController::class, 'postDemo'])->name('demoNe');

Route::get('download-image', [HomeController::class, 'downloadImage'])->name('download-image');
Route::get('download-pdf', [HomeController::class, 'downLoadPdf'])->name('download-pdf');

// nguoi dung
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/add', [UserController::class, 'add'])->name('add');
    Route::post('/add', [UserController::class, 'postAdd'])->name('post-add');
    Route::get('/edit/{id}',[UserController::class,'getEdit'])->name('edit');
    Route::post('/update',[UserController::class,'postEdit'])->name('post-edit');
    Route::get('/delete/{id}',[UserController::class, 'delete'])->name('delete');
});
