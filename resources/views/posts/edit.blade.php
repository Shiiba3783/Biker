@extends('layouts.default')
 
@section('title', $title)
 
@section('content')
  <form method = "POST" action = "{{ route('posts.update', $post) }}" class = "p-3">
      @csrf
      @method('patch')
      <div class="form-group">
        <label for = "tags">タグ:</label>
          <input class="form-control" type = "text" name = "tags" id = "tags" 
            value = "@foreach($post->tags as $tag) {{$tag->name}} @endforeach" 
            placeholder = "#kawasaki #ネイキッド" >
      </div>
      <div>
        <label for = "comment">コメント:</label>
          <textarea class="form-control" name = "comment" cols="50" rows="10" id = "comment">{{$post->comment}}</textarea>
      </div>
      <input type = "submit" value = "投稿" class = "mt-2">
  </form>
@endsection