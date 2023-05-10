<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\DashboardController;

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

// Client Route

Route::get('/', [HomeController::class, 'index'])->middleware('auth.admin');


//Route::get('/', function () {
//    $title = 'Hoc lap trinh web';
//    $content = 'Hoc lap trinh laravel tai unicode';
//    $dataView = [
//        'titleData' => $title,
//        'contentData' => $content
//    ];
//    return view('home', $dataView); // load views form.php vao
// return '<h1 style="text-align: center">Trang chu!</h1>';
//});

Route::get('/auth', function () {
    return '<h1 style="text-align: center">Khong du quyen</h1>';
})->name('auth');

Route::middleware('auth.admin')->prefix('categories')->group(function () {
    // Danh sach chuyen muc
    Route::get('/', [CategoriesController::class, 'index'])->name('categories.list');

    // Lay chi tiet danh muc(Ap dung showForm sua chuyen muc)
    Route::get('/edit/{id}', [CategoriesController::class, 'getCategory'])->name('categories.edit');

    // su ly update chuyen muc
    Route::patch('/edit/{id}', [CategoriesController::class, 'updateCategory']);

    // Hien thi form add du lieu
    Route::get('/add', [CategoriesController::class, 'addCategory'])->name('categories.add');

    // Xu ly them chuyen muc
    Route::post('/add', [CategoriesController::class, 'handleAddCategory']);

    // Xoa chuyen muc
    Route::delete('/delete/{id}', [CategoriesController::class, 'deleteCategory'])->name('categories.delete');

    // Show form upload
    Route::get('/upload', [CategoriesController::class, 'getFile']);

    // Xu ly upload file
    Route::post('upload', [CategoriesController::class, 'handleFile'])->name('categories.upload');
});

Route::get('san-pham/{id}', [HomeController::class, 'getProductDetail']);

// Admin Route
Route::middleware('auth.admin')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
//    Route::middleware('auth.admin.product')->resource('products', ProductsController::class); // C1
    Route::resource('products', ProductsController::class)->middleware('auth.admin.product'); // C2
});



// <===============HOC ROUTE=================>

//Route::get('/', function () {
//    $html = '<h1> Hoc lap trinh </h1>';
//    return $html;
//});
//
//Route::get('unicode', function (){
//    return 'Phuong thuc get cua path /unicode';
//});
//
//Route::get('unicode', function () {
//    return view('form');
//});
//
//Route::post('/unicode', function () {
//    return 'Phuong thuc post cua path /unicode';
//});
//
//Route::put('unicode', function () {
//    return 'Phuong thuc put cua path /unicode';
//});
//
//Route::delete('unicode', function () {
//    return 'Phuong thuc delete cua path /unicode';
//});
//
//Route::patch('unicode', function (){
//    return 'Phuong thuc patch cua path /unicode';
//});

//Route::match(['get','post'], 'unicode',function (){ NHAN NHIEU REQUEST
//   return $_SERVER['REQUEST_METHOD'];
//});

//Route::any('unicode', function (Request $request){
//   // return $_SERVER['REQUEST_METHOD'];
////    $request = new Request();
//    return $request->method();
//});
//
//Route::get('show-form' , function (){
//    return view('form');
//});

//Route::redirect('unicode','show-form');

//Route::view('show-form','form');

//Route::prefix('admin')->group(function () {

//    Route::get('tin-tuc/{slug}-{id}.html', function (  $chuoi,$maso) {
//        $content = 'Phuong thuc get cua path /unicode voi tham so: ';
//        $content .= 'id = ' . $maso .'<br/>';
//        $content .= 'slug = ' . $chuoi;
//        return $content;
//    });
// VI DU THAM SO
//    Route::get('tin-tuc/{id?}/{slug?}', function ($id = 0, $slug = null) {
//       $content = 'Phuong thuc get cua path/tin-tuc voi tham so: ';
//       $content .= 'id = ' . $id . '<br/>';
//       $content .= 'slug = ' . $slug;
//       return $content;
//    });


// VI DU VALIDATE THAM SO
//    Route::get('tin-tuc/{slug}-{id}.html', function ($slug, $id) {
//        $content = 'Phuong thuc get cua path/tin-tuc voi tham so: ';
//        $content .= 'id = ' . $id . '<br/>';
//        $content .= 'slug = ' . $slug;
//        return $content;
//    })
//        ->where(// C1 : DUNG MANG
//            [
//                'slug' => '[0-9a-z-]+',
//                'id' => '[0-9]+',
//            ]
//        );
//        ->where('id', '[0-9]+') // C2: Dung bth
//        ->where('slug', '[0-9a-z-]+');

//    Route::get('show-form', function () {
//        return view('form');
//    })->name('admin.show-form');
//
//    Route::get('tin-tuc/{id?}/{slug?}.html', function ($id = null, $slug = null) {
//        $content = 'Phuong thuc get cua path/tin-tuc voi tham so: ';
//        $content .= 'id = ' . $id . '<br/>';
//        $content .= 'slug = ' . $slug;
//        return $content;
//    })
//        ->where('id', '[0-9]+') // C2: Dung bth
//        ->where('slug', '[0-9a-z-]+')->name('admin.tintuc');


//    Route::prefix('products')->group(function () {
//        Route::get('/', function () {
//            return 'Danh sach san pham';
//        });
//
//        Route::get('add', function () {
//            return 'Them san pham';
//        })->name('admin.products.add');
//
//        Route::get('edit', function () {
//            return 'Sua san pham';
//        });
//
//        Route::get('delete', function () {
//            return 'Xoa san pham';
//        });
//    });


//    Route::prefix('products')->middleware('checkPermission')->group(function () {
//        Route::get('/', function () {
//            return 'Danh sach san pham';
//        });
//
//        Route::get('add', function () {
//            return 'Them san pham';
//        })->name('admin.products.add');
//
//        Route::get('edit', function () {
//            return 'Sua san pham';
//        });
//
//        Route::get('delete', function () {
//            return 'Xoa san pham';
//        });
//    });
//});

//Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
//
//Route::get('/tin-tuc', 'App\Http\Controllers\HomeController@getNews')->name('news');
//
//Route::get('chuyen-muc/{id}', [HomeController::class, 'getCategories']);
//
//Route::get('/', [HomeController::class, 'showPageHome']);



