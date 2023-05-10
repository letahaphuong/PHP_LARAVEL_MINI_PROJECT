<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function __construct(Request $request)
    {
        /**
         * Nếu là trang danh sách chuyên mục thì ta hiển thị ra dòng chữ : Xin chào unicode.
         */
//        if ($request->is('categories')){
//            echo '<h3>Xin chào unicode.</h3>';
//        }
    }

    // hien thi danh sach
    public function index(Request $request)
    {
        // ================$request->all()===================

//        $allData = $request->all();
//        echo $allData['id'];
//        dd($allData);

        // ================$request->path()===================

//        $path = $request->path();
//        echo $path;

        // ================$request->url() && $request->fullUrl()===================

//        $url = $request->url();
//        $fullUrl = $request->fullUrl();
//        echo $fullUrl;

        // ================$request->method() && $request->isMethod()===================

//        $method = $request->method();
//        echo $method;

//        if ($request->isMethod('GET')){
//            echo 'Day la phuong thuc get';
//        }

        // ================$request->ip()===================

//        $ip = $request->ip();
//        echo 'ip la: '. $ip;

        // ================$request->serve()===================

//        $server = $request->server();
//        echo '<pre>';
//        print_r($server['HTTP_COOKIE']);

        // ================$request->header()===================

//        $header = $request->header('host');
//        dd($header);

        // ================$request->input()===================

//        $input = $request->input('id');
//        echo $input;

//        $input = $request->input('id.*.name');
//        dd($input);

        // ================$request->input()===================

//        $id = $request->query('id');

//        $query = $request->query();
//        dd($query);


        // ================$request->name ===================


//        $id = $request->id;
//        $name = $request->name;
//        dd($id[1], $name);


        // <============ HELPER - request() ==============>
        /**
         * Có 2 tham số là key và default
         */
//        $id = request('id');
//        $name = request('name','unicode');
//        dd($id,$name);


        return view('clients/categories/list');
    }

    // lay ra 1 danh muc theo id
    public function getCategory($id)
    {
        return view('clients/categories/edit');
    }

    // cap nhat 1 danh muc
    public function updateCategory($id)
    {
        return 'Submit sua chuyen muc: ' . $id;
    }

    // show form them du lieu(GET)
    public function addCategory(Request $request)
    {
//        $path = $request->path();
//        echo $path;

        // =========== $request->old() ==============

//        $cateName = $request->old('category_name');
//
//        return view('clients/categories/add', compact('cateName'));
        return view('clients/categories/add');
    }

    // them du lieu(POST)
    public function handleAddCategory(Request $request)
    {
//        if ($request->isMethod('post')){
//            echo 'Day la phuong thuc post';
//        }

//        $allData = $request->all();
//        echo $allData['id'];
//        echo '<pre>';
//        print_r($allData);

        // =========== $request->query() ==============

//        $cateName = $request->category_name;
//        $id = $request->id;
//        $producer = $request->producer;
//        dd($cateName, $id, $producer);

        // =========== $request->has() ==============

//        if ($request->has('category_name')) {
//            $cateName = $request->category_name;
//            dd($cateName);
//        } else {
//            return 'Khong co category_name';
//        }
//        return redirect(route('categories.add'));
//        return 'submit them chuyen muc';

        // =========== $request->flash() ==============

        if ($request->has('category_name')) {
            $cateName = $request->category_name;
            $request->flash(); // SET SESSION flash
            return redirect(route('categories.add'));

        } else {
            return 'Khong co category_name';
        }
//        return redirect(route('categories.add'));
//        return 'submit them chuyen muc';
    }

    // Xoa du lieu
    public function deleteCategory($id)
    {
        return 'submit xoa chuyen muc: ' . $id;
    }

    public function getFile()
    {
        return view('clients.categories.file');
    }

    // Xu ly lay thong tin file
    public function handleFile(Request $request)
    {
        // $file = $request->file('photo');
        if ($request->photo) {
            if ($request->photo->isValid()) {
                $file = $request->photo;
//                $path = $file->path();
                $ext = $file->extension(); // lay duoi file
                // $path =  $file->store('photo');
//                $path = $file->storeAs('photo', 'khoa-hoc-' . date('Y-m-d') . '.txt');
//                dd($file);
//                $fileName = $file->getClientOriginalName();
                // DOI TEN

                $fileName = md5(uniqid()) . '.' . $ext;

                dd($fileName);
            } else {
                return 'Upload khong thanh cong';
            }

        } else {
            echo 'file chua upload';
        }

    }
}
