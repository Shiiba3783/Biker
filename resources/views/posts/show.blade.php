@extends('layouts.default')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  
  <ul>
                    @forelse($post->comments as $comment)
                        <li>
                            {{ $comment->user->name }}:{{ $comment->body }}
                        </li>
                    @empty
                        <li>コメントはありません。</li>
                    @endforelse
                </ul>
                <div>
                    <form method = "post" action = "{{ route('comments.store') }}">
                        @csrf
                        <input type = "hidden" name = "post_id" value = "{{ $post->id }}">
                        <label>
                            コメントを追加
                            <input type = "text" name = "body">
                        </label>
                        <input type = "submit" value = "送信">
                    </form> 
                </div>
@endsection