<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public $posts;

    /**
     * @param
     */
    public function __construct()
    {
        $this->posts = new Post();
    }

    public function index()
    {
        $allPost = Post::all();
//        if (count($allPost) >0){
//            foreach ($allPost as $item){
//                echo $item->title . '<br/>';
//            }
//        }

//        $detail = Post::find(1);
//        dd($detail);

//        $activePost = Post::where('status', 0)
//            ->orderBy('title', 'asc')->get();
//        if (count($activePost) > 0) {
//            foreach ($activePost as $item) {
//                echo $item->status . '<br/>';
//            }
//        }

//        $allPost = Post::all();
//        $activePost =  $allPost->reject(function ($post) {
//            return $post->status > 1;
//        });
//        echo '<pre>';
//        dd($activePost) ;

//        Post::chunk(2, function ($posts){
//            dd($posts);
//           foreach ($posts as $post){
//               echo $post->title . '<br/>';
//           }
//        });

        dd(Post::cursor());
    }


    public function add()
    {
        $dataInsert = [
            'title' => 'Bị hại vụ Alibaba: "Có lô đất nào lên thổ cư được thì cho xin một lô"!',
            'content' => 'Bị hại vụ Alibaba: "Có lô đất nào lên thổ cư được thì cho xin một lô"!',
            'status' => 1
        ];

//        $post = Post::create($dataInsert);
//        Post::insert($dataInsert);
//        dd(Post::insert($dataInsert));

//        $post = Post::firstOrCreate([
//            'id' => 12
//        ], $dataInsert);
//        dd($post);

        $post = new Post();
        $post->title = 'Bai dang 123';
        $post->content = 'Bai Dang Moi';

        dd($post->save());
    }

}
