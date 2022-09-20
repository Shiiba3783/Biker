@extends('layouts.default')
 
@section('title', $title)

@section('content_header')
    <div class = "container-fluid bg-white pb-3 show-header fixed-top">
        <div class = "container p-0 ">
            <div class = "row justify-content-between mx-5">
                   <a href = "{{route('users.show', $post->user) }}">
                       <div>
                            @if($post->user->image !== '')
                                <img src = "{{asset('storage/' .$post->user->image)}}" alt = "{{$post->user->name}}" class = "img-fluid rounded-circle">
                            @else
                                <img src = "{{ asset('images/no_image_user.jpg') }}" alt = "no_image" class = "img-fluid rounded-circle">
                            @endif
                            <span class ="ml-1">
                                {{ $post->user->name }}
                            </span>
                        </div>
                    </a>
               <div>
                @if($post->user->id !== Auth::user()->id)
                    @if(Auth::user()->isFollowing($post->user))
                        <form method = "post" action = "{{ route('follows.destroy', $post->user) }}">
                            @csrf
                            @method('delete')
                            <button type = "submit" class = "btn btn-info">フォロー解除</button>
                        </form>
                            
                    @else
                        <form method = "post" action = "{{ route('follows.store') }}">
                            @csrf
                            <input type = "hidden" name = "follow_id" value = "{{ $post->user->id }}">
                            <button type = "submit" class = "btn btn-info">フォローする</button>
                        </form>
                    @endif
                    
                @else
                        <a href = "{{ route('posts.edit_image', $post) }}" class = "btn btn-outline-secondary mr-3">画像を変更</a>
                        <a href = "{{ route('posts.edit', $post) }}" class="btn btn-outline-warning mr-3">コメントを変更</a>
                        <form method="post" class="delete" action="{{ route('posts.destroy', $post) }}">
                          @csrf
                          @method('delete')
                          <button class = "btn btn-outline-danger" type="submit">投稿を削除</button>
                        </form>

                @endif
                </div>
            </div>
        </div>
    </div>
@endsection
 
@section('content')
    <div class = "row mt-5" style = "padding-top:64px">
        <div class = "col-8">
           <div class = "carousel slide  carousel-container" id = "cl" data-ride = "carousel" data-interval="false">
                @if($post->image1 !== '' && $post->image1 !== null)
                   <div class="carousel-indicators">
                       
                        @php
                            foreach([0,1,2,3] as $num){
                                eval('$flag=($post->image'.$num.'!=="");');
                                if($flag){
                                    print '<span data-target = "#cl" data-slide-to=';
                                    eval('print $num' . ';');
                                    print '>';
                                    print '<img src = " '.url('/').'/storage/';
                                    eval('print $post->image'.$num.';');
                                    print '"';
                                    print 'alt = image';
                                    eval('print $num' . ';');
                                    print '>';
                                    print '</span>';
                                }
                            }
                        @endphp
                        {{-- 
                        <span data-target = "#cl" data-slide-to="0" class="active">
                            <img src = "{{ asset('storage/' . $post->image0 )}}" alt = "image01">
                        </span>
                        <span data-target = "#cl" data-slide-to="1">
                            <img src = "{{ asset('storage/' . $post->image1 )}}" alt = "image02">
                        </span>
                        @if($post->image2 !== '' && $post->image2 !== null)
                            <span data-target = "#cl" data-slide-to="2">
                                <img src = "{{ asset('storage/' . $post->image2 )}}" alt = "image03">
                            </span>
                        @endif
                        @if($post->image3 !== '' && $post->image3 !== null)
                            <span data-target = "#cl" data-slide-to="3">
                                <img src = "{{ asset('storage/' . $post->image3 )}}" alt = "image04">
                            </span>
                        @endif
                        --}}
                    </div>
                @endif
               <div class = "carousel-inner w-100 h-100">
                   @if($post->image0 !== '' && $post->image0 !== null)
                   <div class = "carousel-item active">
                       <img src = "{{ asset('storage/' . $post->image0 )}}" class = "carousel-item-image" alt = "image01">
                   </div>
                   @endif
                   @if($post->image1 !== '' && $post->image1 !== null)
                    <div class = "carousel-item">
                       <img src = "{{ asset('storage/' . $post->image1 )}}" class = "carousel-item-image" alt = "image02">
                   </div>
                   @endif
                   @if($post->image2 !== '' && $post->image2 !== null)
                    <div class = "carousel-item"> 
                       <img src = "{{ asset('storage/' . $post->image2 )}}" class = "carousel-item-image" alt = "image03">
                   </div>
                   @endif
                   @if($post->image3 !== '' && $post->image3 !== null)
                    <div class = "carousel-item">
                       <img src = "{{ asset('storage/' . $post->image3 )}}" class = "carousel-item-image" alt = "image04">
                   </div>
                   @endif
                </div>
                <div class = "carousel-control">
                    <a class="carousel-control-prev" href = "#cl" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#cl" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
            <div class = "sub_container row mx-auto">
                <div class = "row ml-auto m-3">
                        <div class = "comment_button border mr-3">
                            <a href = "#comment" class = "comment_link">
                                <i class="fas fa-comment"></i>
                                <span>&nbsp;{{ $post->comments->count() }}</span>
                            </a>
                        </div>
                    <div class = "likes border">
                        @if($post->isLikedBy(Auth::user()))
                        <div class = "like_delete like_button">
                            <a><i class="fas fa-heart"></i></a>
                            <span>&nbsp;{{ $post->likes->count() }}</span>
                        </div>
                        @else
                        <div class = "like_store like_button">
                            <a><i class="fas fa-heart"></i></a>
                            <span>&nbsp;{{ $post->likes->count() }}</span>
                        </div>
                        @endif
                        <form method="post" class="like" action="{{ route('posts.toggle_like', $post) }}">
                          @csrf
                          @method('patch')
                        </form>
                    </div>
                </div>
            </div>
            <div class = "sub_container mt-3 ">
                <div class = "comment_container m-3">
                    <p>{{ $post->user->name }}さんへのコメント</p>
                    <ul>
                        @forelse($post->comments as $comment)
                            <li class = "row comment_box">
                                <div class = "comment_user">
                                    @if($comment->user->image !== '')
                                        <img src = "{{ asset('storage/' . $comment->user->image )}}" alt = "{{ $comment->user->name}}" class = "img-fluid rounded-circle">
                                    @else
                                        <img src = "{{ asset('images/no_image_user.jpg') }}" alt = "{{$comment->user->name}}" class = "img-fluid rounded-circle">
                                    @endif
                                    <p>{{ $comment->user->name }}</p>
                                </div>
                                <div class = "comment_main">
                                        {{ $comment->body }}
                                </div>
                                <div class = "comment_meta">
                                        {{ $comment->created_at->format('Y/m/d') }}
                                </div>
                            </li>
                        @empty
                            <li class = "row"><p class = "no_comment">NO COMMENT</p></li>
                        @endforelse
                    </ul>
                    
                </div>
            
                <div id = "comment" class = "comment_store border-top">
                    <div class = "p-3">
                        <form method = "post" action = "{{ route('comments.store') }}">
                            @csrf
                            <input type = "hidden" name = "post_id" value = "{{ $post->id }}">
                            <label>
                                <span class = "comment_user">
                                    @if(\Auth::user()->image !== '')
                                        <img src = "{{ asset('storage/' . \Auth::user()->image )}}" alt = "{{ \Auth::user()->name }}" class = "img-fluid rounded-circle">
                                    @else
                                        <img src = "{{ asset('images/no_image_user.jpg') }}" alt = "{{ \Auth::user()->name }}" class = "img-fluid rounded-circle">
                                    @endif
                                </span>
                                <input type = "text" name = "body" size = "40" placeholder = "コメントを書く">
                            </label>
                            <input type = "submit" value = "送信">
                        </form> 
                    </div>
                </div>
            </div>
        </div>
        <div class = "col-4 body_conteiner">
            <div class = "border bg-white container">
                <p class = "p-3">{{ $post->comment }}</p>
                @foreach($post->tags as $tag)
                    <a href = "{{route('tags.index', $tag)}}" class=" mb-1">{{$tag->name}}</a>
                @endforeach
                <p class = "border-top text-center text-secondary">{{$post->created_at}}</p>
            </div>
        </div>
        
       {{--
       @foreach($images as $value => $image)
            @if($image !== '' && $image !== null)

                <div class = "col-4">
                    <img src = "{{ asset('storage/' . $image )}}" class = "img-fluid item-image">

                </div>
            @endif
        @endforeach
        --}}
    </div>
@endsection