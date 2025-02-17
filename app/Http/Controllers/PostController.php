<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    function index()
    {
        // $posts = Post::all();
        //dd($posts);
        // return view('posts.index',compact('posts'));
        return view('posts.show');
    }
    function map()
    {
        // $posts = Post::all();
        //dd($posts);
        // return view('posts.index',compact('posts'));
        return view('posts.map');
    }
    function main()
    {
        // $posts = Post::all();
        //dd($posts);
        // return view('posts.index',compact('posts'));
        return view('posts.main');
    }
    function show()
    {
        // $posts = Post::all();
        //dd($posts);
        // return view('posts.index',compact('posts'));
        return view('posts.show');
    }
}
