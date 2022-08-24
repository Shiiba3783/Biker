<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserImageRequest;
use App\Post;
use App\Follow;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', [
            'title' => 'プロフィール',
            'user' => $user,
            ]);
    }
    
    public function edit()
    {
        $user = \Auth::user();
        return view('users.edit', [
            'title' => 'プロフィール変更',
            'user' => $user,
            ]);
    }
    
    public function update(UserRequest $request)
    {
        $user = \Auth::user();
        $user->update($request->only(['name','email','profile']));
        session()->flash('success', 'プロフィールを更新しました');
        return redirect()->route('users.show', $user);
    }
    
    public function editImage()
    {
        $user = \Auth::user();
        return view('users.edit_image', [
            'title' => 'プロフィール画像変更',
            'user' => $user,
            ]);
    }
    
    public function updateImage(UserImageRequest $request)
    {
        $path = '';
        $image = $request->file('image');
        if(isset($image) === true) {
            $path = $image->store('profiles', 'public');
        }
        
        $user = \Auth::user();
        
        if($user->image !== '') {
            \Storage::disk('public')->delete($user->image);
        }
        
        $user->update([
            'image' => $path,
            ]);
            
        session()->flash('success', '画像を変更しました');
        return redirect()->route('users.show', $user);
    }
    
    public function userFollows($id) 
    {
        $user = User::find($id);
        $follow_users = $user->follow_users;
        return view('users.user_follows', [
            'title' => $user->name . 'のフォロー一覧',
            'follow_users' => $follow_users,
            ]);
    }
    
    public function userFollowers($id) 
    {
        $user = User::find($id);
        $followers = $user->followers;
        return view('users.user_followers', [
            'title' => $user->name . 'のフォロワー一覧',
            'followers' => $followers,
            ]);
    }
    
    
    
        public function __construct()
    {
        $this->middleware('auth');
    }

}
