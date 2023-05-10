<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    // Action index()
    public function index()
    {
        $title = 'Hoc lap trinh web';
        $content = 'Hoc lap trinh laravel tai unicode';

        /**
         * compact('title', 'content') sẽ tương ứng với mãng $dataView
         *
         * $dataView = [
         * 'title' => $title,
         * 'content' => $content
         * ];
         */
//        $dataView = [
//            'titleData' => $title,
//            'contentData' => $content
//        ];
        // return view('home', compact('title', 'content')); // load views form.php vao
        // return view('home')->with(['title' => $title, 'content' => $content]);

         return View::make('home')->with(['title'=>$title , 'content' => $content]);

//        $contentView = view('home')->render();
//        $contentView = $contentView->render();
//        dd($contentView);
//        return $contentView;
    }

    //Action getNews()
    public function getNews()
    {
        return 'Danh sach tin tuc';
    }

    // Action getCategories($id)
    public function getCategories($id)
    {
        return 'Danh muc' . $id;
    }

    public function showPageHome()
    {
        return view('welcome');
    }

    public function getProductDetail($id){
        return view('clients.products.detail', compact('id'));
    }
}
