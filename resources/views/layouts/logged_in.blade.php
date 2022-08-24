@extends('layouts.default')
 
@section('header')
<header>
    <ul class="header_nav">
        <li>
          <a href="{{ route('posts.index') }}">
            投稿一覧
          </a>
        </li>
        <li>
          <a href="{{ route('likes.index') }}">
            いいねリスト
          </a>
        </li>
        <li>
          <a href = "{{ route('users.show', \Auth::user()) }}">プロフィール</a>
        </li>
        <li>
          <form action="{{ route('logout') }}" method="POST">
                @csrf
                <input type="submit" value="ログアウト">
          </form>
        </li>
    </ul>
</header>
@endsection