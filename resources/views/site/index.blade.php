@extends('template')

@section('title', 'Workshop')


@section('main')

<div class="intro-container d-flex align-items-center">
    <div class="intro-content mx-5 px-5">
        <h1>Workshop<span>Create your own blog</span></h1>
        <p>This website is place where you can create your posts.</p>
        <p>Read other users created posts.</p>
        <p>Besides that, you can comment other users created posts and even like them, if you really like them.</p>
        <div class="intro-buttons">
            @if(Auth::check())
                <a class="btn btn-secondary ws-button ws-link-button ws-link-dark" href="{{url('post/create')}}">Create Post</a>
            @else
                <a class="btn btn-secondary ws-button ws-link-button ws-link-dark" href="{{url('login')}}">Login</a>
            @endif
            <a class="btn btn-secondary ws-button ws-link-button ml-5" href="{{url('posts')}}">View Posts</a>
        </div>
    </div>
</div>

<div class="container section-container">

    @if (!count($latestPosts))
        <h2 class="text-center">No Posts to show</h2>
    @else
        <h2 class="text-center">Latest blog posts</h2>
    @endif

    <div class="row posts justify-content-center">
        @foreach ($latestPosts as $post)
            <div class="col-12 col-lg-3">
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
                        <div class="post-stats d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-eye"></i>
                                <span>{{$post->views()->count()}}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa fa-comment"></i>
                                <span>{{$post->comments()->count()}}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fa fa-heart"></i>
                                <span>{{$post->likes()->count()}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a class="post-link ws-button-link ws-button-yellow" href="{{$post->getLink()}}">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        <a class="btn btn-default ws-button-link mt-2" href="{{url('posts')}}">View all posts</a>
    </div>
</div>

<div class="container-fluid section-container mb-0 ws-bg-yellow">
    <div class="row justify-content-center gloabl-statistics">
        <div class="col-2 text-center single-statistic">
            <h5>Users</h5>
            <p>{{$userCount}}</p>
        </div>
        <div class="col-2 text-center single-statistic">
            <h5>Posts</h5>
            <p>{{$postCount}}</p>
        </div>
        <div class="col-2 text-center single-statistic">
            <h5 class="m-0">Total Likes</h5>
            <p>{{$likesCount}}</p>
        </div>
        <div class="col-2 text-center single-statistic">
            <h5 class="m-0">Total comments</h5>
            <p>{{$commentCount}}</p>
        </div>

        <div class="col-2 text-center single-statistic">
            <h5 class="m-0">Submited forms</h5>
            <p>{{$commentCount}}</p>
        </div>
    </div>
</div>


<div class="bg-white pt-5 my-0 section-container">
    <div id="ws-carousel" class="carousel slide" data-ride="carousel">
        <div class="container">
            <div class="carousel-inner">
                @if (!count($viewedPots))
                    <div class="carousel-item active px-5">
                        <div class="d-flex flex-column py-5 align-items-center justify-content-center">
                            <h2 class="text-center">Be first to create post because there is nothing to show yet.</h2>
                            <a class="btn btn-default ws-button-link mt-2" href="{{url('post/create')}}">Create Post</a>
                        </div>
                    </div>
                @else
                    <div class="carousel-item active px-5">
                        <div class="container px-5">
                            <h2 class="text-center">Top viewd posts</h2>
                            <div class="row posts justify-content-center">
                                @foreach ($viewedPots as $post)
                                    <div class="col-12 col-lg-4">
                                        <div class="d-flex flex-column post position-relative">
                                            <div class="post-place">
                                                <i class="fa fa-eye"></i>
                                                <span>{{$post->views->count() }}</span>
                                            </div>
                                            <div class="ws-img-container">
                                                <img src="{{$post->getPicture()}}" class="img-fluid w-100 h-auto">
                                            </div>
                                            <div class="post-container">
                                                <h3 class="post-title text-center">{{$post->title}}</h3>
                                                <p class="post-description">{{$post->getShortBody()}}</p>
                                            </div>
                                            <div class="post-stats mx-3 d-flex justify-content-around">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-comment"></i>
                                                    <span>{{$post->comments()->count()}}</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-heart"></i>
                                                    <span>{{$post->likes()->count()}}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mt-2">
                                                <a class="post-link ws-button-link ws-button-yellow" href="{{$post->getLink()}}">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(count($activeUsers))
                    <div class="carousel-item user-carousel-item px-5">
                        <div class="container px-5">
                            <h2 class="text-center">Most active users</h2>
                            <div class="row justify-content-center">
                                @foreach ($activeUsers as $user)
                                    <div class="col-12 col-lg-4">
                                        <div class="d-flex flex-column post position-relative">
                                            <div class="ws-img-container">
                                                <img src="{{$user->getProfilePicture()}}" class="img-fluid w-100 h-auto">
                                            </div>
                                            <div class="user-container">
                                                <h3 class="text-center"><a href="{{$user->getLink()}}">{{$user->getFullname()}}</a></h3>
                                                <div class="user-statistic d-flex justify-content-around">
                                                    <div class="user-stat d-flex flex-column">
                                                        <i class="fa fa-comment"></i>
                                                        <span>{{$user->comments->count()}}</span>
                                                    </div>
                                                    <div class="user-stat d-flex flex-column">
                                                        <i class="fa fa-eye"></i>
                                                        <span>{{$user->profileViews->count()}}</span>
                                                    </div>
                                                    <div class="user-stat d-flex flex-column">
                                                        <i class="fa fa-scroll"></i>
                                                        <span>{{$user->posts->count()}}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <a class="post-link ws-button-link ws-button-yellow" href="{{$user->getLink()}}">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(count($likedPosts))
                    <div class="carousel-item px-5">
                        <div class="container px-5">
                            <h2 class="text-center">Most favored posts</h2>
                            <div class="row posts justify-content-center">
                                @foreach ($likedPosts as $post)
                                    <div class="col-12 col-lg-4">
                                        <div class="d-flex flex-column post position-relative">
                                            <div class="post-place">
                                                <i class="fa fa-heart"></i>
                                                <span>{{$post->likes->count() }}</span>
                                            </div>
                                            <div class="ws-img-container">
                                                <img src="{{$post->getPicture()}}" class="img-fluid w-100 h-auto">
                                            </div>
                                            <div class="post-container">
                                                <h3 class="post-title text-center">{{$post->title}}</h3>
                                                <p class="post-description">{{$post->getShortBody()}}</p>
                                            </div>
                                            <div class="post-stats d-flex justify-content-around">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-eye"></i>
                                                    <span>{{$post->views()->count()}}</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-comment"></i>
                                                    <span>{{$post->comments()->count()}}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mt-2">
                                                <a class="post-link ws-button-link ws-button-yellow" href="{{$post->getLink()}}">Read Post</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <a class="carousel-control-prev text-secondary" href="#ws-carousel" role="button" data-slide="prev">
            <i class="carousel-icon fas fa-chevron-left" aria-hidden="true"></i>
        </a>
        <a class="carousel-control-next text-secondary" href="#ws-carousel" role="button" data-slide="next">
            <i class="carousel-icon fas fa-chevron-right" aria-hidden="true"></i>
        </a>
    </div>
</div>

<div class="container-fluid section-container mb-0 mt-0 ws-bg-dark contact-section">
    <div class="row justify-content-center p-5">
        <div class="col-12 col-md-8 text-center">
            <h2>Want contact author of Workshop?</h2>
            <p>If you wish too contact me, you can navigate to contact page and submit form. I will recive your message and ASAP will responde you. Carry on.</p>
            <div class="d-flex justify-content-center mt-4">
                <a class="btn btn-default ws-button-link text-white" href="{{url('posts')}}">View all posts</a>
            </div>
        </div>
    </div>
</div>
@endsection
