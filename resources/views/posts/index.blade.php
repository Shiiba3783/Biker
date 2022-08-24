@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <a href = "{{ route('posts.create') }}">新規投稿</a>
  <ul>
        @forelse($posts as $post)
            <li>
                <div>
                    @if($post->image !== '')
                        <img src = "{{ asset('storage/' . $post->image) }}">
                    @else
                        <img src = "{{ asset('images/no_image.png') }}">
                    @endif
                    
                    @if(\Auth::user()->id === $post->user->id)
                        <a href = "{{ route('posts.edit_image', $post) }}">画像を変更</a>
                    @endif
                    
                </div>
                <div>
                    <a href = "{{ route('users.show', $post->user) }}">{{ $post->user->name }}</a>:
                    {{ $post->comment }} 
                    ({{ $post->created_at }})
                    <span>
                        <a class="like_button">{{ $post->isLikedBy(Auth::user()) ? '★' : '☆' }}</a>
                        <form method="post" class="like" action="{{ route('posts.toggle_like', $post) }}">
                          @csrf
                          @method('patch')
                        </form>
                    </span>
                </div>
                <div>
                    @if(\Auth::user()->id === $post->user->id)
                        [<a href = " {{ route('posts.edit', $post) }}">編集</a>]
                        <form method = "post" class = "delete" action = "{{ route('posts.destroy', $post) }}">
                            @csrf
                            @method('delete')
                            <input type = "submit" value = "削除">
                        </form>
                    @endif
                </div>
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
            </li>
        @empty
            <li>書き込みはありません。</li>
        @endforelse
  </ul>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      /* global $ */
      $('.like_button').on('click', (event) => {
          $(event.currentTarget).next().submit();
      })
  </script>

@endsection