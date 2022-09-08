<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Http\Requests\PostImageRequest;
use App\User;
use App\Like;
use App\Comment;
use App\Tag;

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
        // $path0 = '';
        // $image = $request->file('image0');
        // if(isset($image) === true) {
        //     $path0 = $image->store('photos', 'public');
        // } 
        // $path1 = '';
        // $image = $request->file('image1');
        // if(isset($image) === true) {
        //     $path1 = $image->store('photos', 'public');
        // }
        // $path2 = '';
        // $image = $request->file('image2');
        // if(isset($image) === true) {
        //     $path2 = $image->store('photos', 'public');
        // }
        // $path3 = '';
        // $image = $request->file('image3');
        // if(isset($image) === true) {
        //     $path3 = $image->store('photos', 'public');
        // } 
        
        $path = [];
        $files = ['image0', 'image1', 'image2', 'image3'];
        foreach($files as $key => $file) {
            $path[] = '';
            $image = $request->file($file);
            if(isset($image) === true) {
                $path[$key] = $image->store('photos', 'public');
            }
        }
        
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->tags, $match);
        
        dd($match);
        
        foreach($match[1] as $record) {
            $tag = Tag::firstOrCreate(['name' => $record]);
            $tag = null;
            
            $tag_id = Tag::where('name', $record)->get(['id']);
            $post = Post::find($post_id);
            $post->tags()->attach($tag_id);
        }
    
        Post::create([
            'user_id' => \Auth::user()->id,
            'comment' => $request->comment,
            'image0' => $path[0],
            'image1' => $path[1],
            'image2' => $path[2],
            'image3' => $path[3],
            ]);
        // $post->tags()->attach($tags_id);
        
        // $tags = Tag::where('name','=',$request->tags);
        // $tag_id = 0;
        // if($tags->count() > 0) {
        //     $tag_id = $tags->first()->id;
        // }else{
        //     $tmp = Tag::create(['name'=>$request->tags]);
        //     $tag_id = $tmp->id;
        // }
        
        
           
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
        $post = Post::find($id);
        $images = Post::select(['image0', 'image1', 'image2', 'image3'])->where('id',$id)->first();
        return view('posts.show', [
          'title' => '投稿詳細',
          'post' => $post,
          'images' => $images,
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
        
        if($post->image0 !== '') {
            \Storage::disk('public')->delete($post->image0);
        }
         if($post->image1 !== '') {
            \Storage::disk('public')->delete($post->image1);
        }
         if($post->image2 !== '') {
            \Storage::disk('public')->delete($post->image2);
        }
         if($post->image3 !== '') {
            \Storage::disk('public')->delete($post->image3);
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
        $path0 = '';
        $image = $request->file('image0');
        if(isset($image) === true) {
            $path0 = $image->store('photos', 'public');
        }
        $path1 = '';
        $image = $request->file('image1');
        if(isset($image) === true) {
            $path1 = $image->store('photos', 'public');
        }
        $path2 = '';
        $image = $request->file('image2');
        if(isset($image) === true) {
            $path2 = $image->store('photos', 'public');
        }
        $path3 = '';
        $image = $request->file('image3');
        if(isset($image) === true) {
            $path3 = $image->store('photos', 'public');
        }
        $post = Post::find($id);
        
        //変更前の画像削除処理
        if($post->image0 !== '') {
            // \Storage::disk('public')->delete(\Storage::url($post->image));
            \Storage::disk('public')->delete($post->image0);
        }
        if($post->image1 !== '') {
            // \Storage::disk('public')->delete(\Storage::url($post->image));
            \Storage::disk('public')->delete($post->image1);
        }
        if($post->image2 !== '') {
            // \Storage::disk('public')->delete(\Storage::url($post->image));
            \Storage::disk('public')->delete($post->image2);
        } 
        if($post->image3 !== '') {
            // \Storage::disk('public')->delete(\Storage::url($post->image));
            \Storage::disk('public')->delete($post->image3);
        }
        
        $post->update([
            'image0' => $path0,
            'image1' => $path1,
            'image2' => $path2,
            'image3' => $path3,
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
