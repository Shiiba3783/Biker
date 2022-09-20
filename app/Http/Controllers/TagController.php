<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Post;
use App\post_tag;


class TagController extends Controller
{
    public function index($id) {
        $tag = Tag::find($id);
        
        $posts = $tag->posts()->get();
        
        return view('tags.index', [
            'posts' => $posts,
            'tag' => $tag, 
            ]);
    }
}
