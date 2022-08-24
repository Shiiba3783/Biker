@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <dl>
        <dt>プロフィール画像</dt>
        <dd>
            @if($user->image !== '')
                <img src = "{{ asset('storage/' . $user->image) }}">
            @else
                <img src = "{{ asset('images/no_image.png') }}">
            @endif
        </dd>
        @if(Auth::id() === $user->id)
            <div>
                <a href = "{{ route('users.edit_image') }}">画像を変更</a>
            </div>
        @endif
    </dl>
    <dl>
        <dt>名前</dt>
        <dd>{{ $user->name }}</dd>
    </dl>
    <dl>
        <dt>プロフィール</dt>
        <dd>
            @if($user->profile !== '' && $user->profile !== null)
                {{ $user->profile }}
            @else
                プロフィールが設定されていません。
            @endif
            
        </dd>
    </dl>
    @if(Auth::id() === $user->id)
        <div>
            [<a href = "{{ route('users.edit') }}">編集</a>]
        </div>
        <div>
            <a href = "{{route('follows.index') }}">フォロー一覧</a>
        </div>
        <div>
            <a href = "{{route('follows.follower') }}">フォロワー一覧</a>
        </div>
    
    @else
        
        @if(Auth::user()->isFollowing($user))
            <form method = "post" action = "{{ route('follows.destroy', $user) }}">
                @csrf
                @method('delete')
                <input type = "submit" value = "フォロー解除">
            </form>
            
        @else
            <form method = "post" action = "{{ route('follows.store') }}">
                @csrf
                <input type = "hidden" name = "follow_id" value = "{{ $user->id }}">
                <input type = "submit" value = "フォロー">
            </form>
            
        @endif
        
        <div>
            <a href = "{{route('users.user_follows', $user) }}">フォロー一覧</a>
        </div>
        <div>
            <a href = "{{route('users.user_followers', $user) }}">フォロワー一覧</a>
        </div>
        
    @endif

    
@endsection