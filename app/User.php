<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profile','image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function posts(){
        return $this->hasMany('App\Post');
    }
    
    public function likes() {
        return $this->hasMany('App\Like');
    }
    
    public function likePosts() {
        return $this->belongsToMany('App\Post', 'likes');
    }
    
    public function follows() {
        return $this->hasMany('App\Follow');
    }
    
    public function follow_users() {
        return $this->belongsToMany('App\User','follows', 'user_id', 'follow_id');
    }
    
    public function followers(){
      return $this->belongsToMany('App\User', 'follows', 'follow_id', 'user_id');
    }
    
    public function isFollowing($user) {
        $result = $this->follow_users->pluck('id')->contains($user->id);
        return $result;
    }
    
    public function getRouteKeyName() {
        return 'name';
    }
    

}
