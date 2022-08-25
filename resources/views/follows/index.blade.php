@extends('layouts.default')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  
    <ul class="follow_users">
        @forelse($follow_users as $follow_user)
            <li class="follow_user">
                <div>
                    @if($follow_user->image !== '')
                        <img src="{{ asset('storage/profiles/' . $follow_user->image) }}">
                    @else
                        <img src="{{ asset('images/no_image.png') }}">
                    @endif
                </div>
                <div>
                    <a href = "{{ route('users.show', $follow_user) }}">{{ $follow_user->name }}</a>
                </div>
                <div>
                    <form method="post" action="{{route('follows.destroy', $follow_user)}}">
                    @csrf
                    @method('delete')
                    <input type="submit" value="フォロー解除">
                    </form>
                </div>
            </li>
        @empty
            <li>フォローしているユーザーはいません。</li>
        @endforelse
    </ul>
    
@endsection