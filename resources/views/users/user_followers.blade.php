@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  
  <ul class="follow_users">
        @forelse($followers as $follower)
            <li class="follow_user">
                <div>
                    @if($follower->image !== '')
                        <img src="{{ asset('storage/profiles/' . $follower->image) }}">
                    @else
                        <img src="{{ asset('images/no_image.png') }}">
                    @endif
                </div>
                <div>
                    <a href = "{{ route('users.show', $follower) }}">{{ $follower->name }}</a>
                </div>
                <div>
                    <form method="post" action="{{route('follows.destroy', $follower)}}">
                    @csrf
                    @method('delete')
                    <input type="submit" value="フォロー解除">
                    </form>
                </div>
            </li>
        @empty
            <li>フォロワーはいません。</li>
        @endforelse
    </ul>
@endsection