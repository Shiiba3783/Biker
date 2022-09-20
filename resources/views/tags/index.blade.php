@extends('layouts.default')
 
@section('title', $tag->name)
 
@section('content')
  <h2>{{ $tag->name }}</h2>
  <div class = "row">
      <div class = "index_main col-9 container">
          <ul class = "row">
            @forelse($posts as $post)
                <li class = "col-4 mt-3">
                    <div class = "post_container border">
                        <div class = "image_container">
                            <a href = "{{ route('posts.show', $post) }}">
                            @if($post->image0 !== '')
                                <img src = "{{ asset('storage/' . $post->image0) }}" alt = "写真" class = "img-fluid item-image">
                            @else
                                <img src = "{{ asset('images/no_image.png') }}" alt = "写真" class = "img-fluid item-image">
                            @endif
                            </a>
                        </div>
                        <div class = "border-top bg-white user_container p-2 row mx-auto">
                            <div>
                               <a href = "{{route('users.show', $post->user) }}">
                                        @if($post->user->image !== '')
                                            <img src = "{{asset('storage/' .$post->user->image)}}" alt = "{{$post->user->name}}" class = "img-fluid rounded-circle">
                                        @else
                                            <img src = "{{ asset('images/no_image_user.jpg') }}" alt = "no_image" class = "img-fluid rounded-circle">
                                        @endif
                                        <span class ="ml-1">
                                            {{ $post->user->name }}
                                        </span>
                                </a>
                            </div>
                            <div class = "ml-auto">
                                <p>{{$post->created_at->format('Y/m/d')}}</p>
                            </div>
                          </div>
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