@extends('layouts.default')

@section('title', $title)

@section('content')

<h1>{{ $title }}</h1>

[<a href = "{{ route('users.show', $user) }}">戻る</a>]

<form method = "POST" action = "{{route('users.update')}}">
    @csrf
    @method('patch')
    <div>
        <label>
            名前:
            <input type = "text" name = "name" value = "{{ $user->name }}">
        </label>
    </div>
    <div>
        <label>
            メールアドレス:
            <input type = "email" name = "email" value = "{{ $user->email }}">
        </label>
    </div>
    <div>
        <div>プロフィール:</div>
        <textarea rows = "20" cols = "40" name = "profile">{{ $user->profile }}</textarea>
    </div>
    <input type = "submit" value = "更新">
</form>

@endsection