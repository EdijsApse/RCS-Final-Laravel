@extends('template')

@section('title', 'Post Title')

@section('main')

<div class="container-fluid ws-container">
    <div class="big-post-page">
        <div class="row justify-content-between position-relative">

            @if($post->user_id == Auth::id())
                <a href="{{$post->getLink().'/edit'}}" class="btn btn-secondary ws-button-link position-absolute ws-absolute-position-link">Edit Post</a>
            @endif

            <div class="col-12 col-lg-8">
                <h1>{{$post->title}}</h1>
                <div class="row">
                    <div class="col-8">
                        <div class="post-image">
                            <img src="{{$post->getPicture()}}" class="img-fluid w-100 h-auto">
                        </div>
                    </div>
                </div>
                <p>{{$post->body}}
                </p>

                <div class="post-details d-flex justify-content-end align-items-center">
                    <i class="fa fa-eye"></i>
                    <span>{{$post->views->count()}}</span>
                    <i class="fa fa-heart ml-4"></i>
                    <span>{{$post->likes->count()}}</span>
                </div>
                <div class="coment-section">
                    @if(Auth::check())
                    <h3 class="text-center">Leave Comment</h3>

                    <form class="ws-form" action="{{$post->getLink()}}/comment" method="post">
                        @csrf
                        <textarea name="comment" placeholder="Enter your comment..." class="ws-textarea"></textarea>
                        @error('comment')
                            <div class="error-message d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>{{ $message }}</p>
                            </div>
                        @enderror
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-secondary ws-button">Submit</button>
                        </div>
                    </form>

                    @else

                    <h3 class="text-center">To leave comment please signe in</h3>

                    <div class="d-flex justify-content-center">
                        <a href="{{url('login')}}" class="btn btn-secondary ws-button-link">Sign In</a>
                    </div>

                    @endif
                    <div>
                        @foreach ($post->comments->sortByDesc('id'); as $comment)
                            <div class="comment d-flex">
                                <div class="user-image">
                                    <img src="{{$comment->user->getProfilePicture()}}">
                                </div>
                                <div class="comment-content">
                                    <h6><a href="{{$comment->user->getLink()}}">{{$comment->user->getFullname()}}</a></h6>
                                    <p>{{$comment->comment}}</p>
                                    <span>{{$comment->getCreateDate()}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if(count($nextPosts))
            <div class="col-12 col-lg-3">
                <h4 class="next-post-title">Read Next</h4>
                <div class="posts">
                    @foreach ($nextPosts as $post)
                        <div class="d-flex flex-column post">
                            <div class="ws-img-container">
                                <img src="{{$post->getPicture()}}" class="img-fluid w-100 h-auto">
                            </div>
                            <div class="post-container">
                                <div class="d-flex justify-content-between mb-3 post-details">
                                    <span>{{$post->getUpdateDate()}}</span>
                                    <span><a href="{{$post->user->getLink()}}">{{$post->user->getFullName()}}</a></span>
                                </div>
                                <h3 class="post-title">{{$post->title}}</h3>
                                <p class="post-description">{{$post->getShortBody()}}</p>
                            </div>
                            <div class="flex justify-self-end justify-content-end">
                                <a class="post-link p-2 align-self-end float-right" href="{{$post->getLink()}}">Read More</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
