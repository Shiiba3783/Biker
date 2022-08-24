<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Http\Requests\PostImageRequest;
use App\User;
use App\Like;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', [
            'title' => '投稿一覧',
            'posts' => $posts,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
          'title' => '新規投稿',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $path = '';
        $image = $request->file('image');
        if(isset($image) === true) {
            $path = $image->store('photos', 'public');
        } 
        
        Post::create([
            'user_id' => \Auth::user()->id,
            'comment' => $request->comment,
            'image' => $path,
            ]);
            
        session()->flash('success', '投稿を追加しました');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('posts.show', [
          'title' => '投稿詳細',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', [
          'title' => '投稿編集',
          'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->only(['comment']));
        session()->flash('success', '投稿を編集しました');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        
        if($post->image !== '') {
            \Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        session()->flash('success', '投稿を削除しました');
        return redirect()->route('posts.index');
    }
    
    public function editImage($id)
    {
        $post = Post::find($id);
        return view('posts.edit_image', [
            'title' => '画像変更画面',
            'post' => $post,
            ]);
    }
    
    public function updateImage($id, PostImageRequest $request)
    {
        //画像投稿処理
        $path = '';
        $image = $request->file('image');
        if(isset($image) === true) {
            $path = $image->store('photos', 'public');
        }
        $post = Post::find($id);
        
        //変更前の画像削除処理
        if($post->image !== '') {
            // \Storage::disk('public')->delete(\Storage::url($post->image));
            \Storage::disk('public')->delete($post->image);
        }
        
        $post->update([
            'image' => $path,
            ]);
            
        session()->flash('success', '画像を変更しました');
        return redirect()->route('posts.index');
    }
    
    public function toggleLike($id){
          $user = \Auth::user();
          $post = Post::find($id);
 
          if($post->isLikedBy($user)){
              // いいねの取り消し
              $post->likes->where('user_id', $user->id)->first()->delete();
              \Session::flash('success', 'いいねを取り消しました');
          } else {
              // いいねを設定
              Like::create([
                  'user_id' => $user->id,
                  'post_id' => $post->id,
              ]);
              \Session::flash('success', 'いいねしました');
          }
          return back();
      }
    
    public function __construct()
    {
        $this->middleware('auth');
    }
}
