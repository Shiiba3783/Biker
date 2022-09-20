@extends('layouts.default')

@section('title', $user->name)

@section('content_header')
    <div class = "container-fluid bg-white pb-3">
        <div class = "container">
            <article class = "user_header row">
                <section>
                    <div class = "text-center">
                        @if($user->image !== '')
                            <img src = "{{ asset('storage/' . $user->image) }}" alt = "{{$user->name}}" class = "img-fluid rounded-circle">
                        @else
                            <img src = "{{ asset('images/no_image_user.jpg') }}" alt = "no_image" class = "img-fluid rounded-circle">
                        @endif
                    </div>
                    <div class = "mt-3 text-center">
                        @if(Auth::id() === $user->id)
                                <a href = "{{ route('users.edit_image') }}">画像を変更</a>
                                
                        @else
                            @if(Auth::user()->isFollowing($user))
                                <form method = "post" action = "{{ route('follows.destroy', $user) }}" style = "display:inline">
                                    @csrf
                                    @method('delete')
                                    <input type = "submit" value = "フォロー解除">
                                </form>
                                
                            @else
                                <form method = "post" action = "{{ route('follows.store') }}" style = "display:inline">
                                    @csrf
                                    <input type = "hidden" name = "follow_id" value = "{{ $user->id }}">
                                    <button type = "submit" class = "btn btn-primary">フォローする</button>
                                </form>
                                    
                            @endif
                        @endif
                    </div>
                    <div class = "mt-3">
                        <a class = "btn btn-info mr-3" href = "{{route('users.user_follows', $user) }}">フォロー一覧</a>
                        <a class = "btn btn-info" href = "{{route('users.user_followers', $user) }}">フォロワー一覧</a>
                    </div>
                </section>
                <section class = "ml-5">
                    <div>
                        <h2 style = "display:inline">{{ $user->name }}</h2>
                        @if(Auth::id() === $user->id)
                            [<a href = "{{ route('users.edit') }}">編集</a>]
                        @endif
                    </div>
                    <div class = "mt-3">
                        <p>
                            @if($user->profile !== '' && $user->profile !== null)
                                {{ $user->profile }}
                            @else
                                プロフィールが設定されていません。
                            @endif
                        </p>    
                    </div>
                </section>
            </article>
        </div>
    </div>
@endsection
    
@section('content')
    <article>
        <div class = "row">
      <div class = "index_main container">
          <ul class = "row">
            @forelse($posts as $post)
                <li class = "col-3 mt-3">
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
    </article>

@endsection