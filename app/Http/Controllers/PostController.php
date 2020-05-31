<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //
    public function index(){
        return [
            'type' => 'success',
            'message' => '',
            'error' => false,
            'data' => Post::all()
        ];
    }

    public function detail($id){
        $post = Post::find($id);
        if(empty($post)){
            return [
                'type' => 'error',
                'message' => 'search other post',
                'error' => 'Post data not found'
            ];
        }

        return [
            'type' => 'success',
            'message' => '',
            'error' => false,
            'data' => $post
        ];
    }
}
