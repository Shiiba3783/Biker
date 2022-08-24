@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <form method = "POST" enctype="multipart/form-data" action = "{{route('posts.store') }}" >
      @csrf
      <div>
        <label>
          画像:
          <input type = "file" name = "image">
        </label>
      </div>
      <div>
        <label>
          コメント:
          <input type = "text" name = "comment">
        </label>
      </div>
      
      <input type = "submit" value = "投稿">
  </form>
@endsection
