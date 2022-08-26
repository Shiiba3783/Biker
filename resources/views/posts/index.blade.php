@extends('layouts.default')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <a href = "{{ route('posts.create') }}">新規投稿</a>
  <div class = "row">
      <!--メインコンテンツ-->
      <div class = "index_main col-9 container">
          <ul class = "row">
            @forelse($posts as $post)
                <li class = "col-4 border">
                    <div class = "image_container">
                        @if($post->image !== '')
                            <img src = "{{ asset('storage/' . $post->image) }}" alt = "写真" class = "img-fluid" width = "232" height = "310" >
                        @else
                            <img src = "{{ asset('images/no_image.png') }}" alt = "写真" class = "img-fluid" width = "232" height = "310">
                        @endif
                        
                        @if(\Auth::user()->id === $post->user->id)
                            <a href = "{{ route('posts.edit_image', $post) }}">画像を変更</a>
                        @endif
                        
                    </div>
                    <div class = "border-top bg-white">
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
                </li>
            @empty
                <li>投稿はありません。</li>
            @endforelse
        </ul>
      </div>
  </div>
  
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      /* global $ */
      $('.like_button').on('click', (event) => {
          $(event.currentTarget).next().submit();
      })
  </script>

@endsection