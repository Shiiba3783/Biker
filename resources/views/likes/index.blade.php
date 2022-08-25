@extends('layouts.default')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <ul>
        @forelse($like_posts as $post)
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
                    {{ $post->user->name }}:
                    {{ $post->comment }} 
                    ({{ $post->created_at }})
                </div>
                <div>
                    <a class="like_button">{{ $post->isLikedBy(Auth::user()) ? '★' : '☆' }}</a>
                    <form method="post" class="like" action="{{ route('posts.toggle_like', $post) }}">
                      @csrf
                      @method('patch')
                    </form>
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
            <li>いいねした投稿はありません。</li>
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