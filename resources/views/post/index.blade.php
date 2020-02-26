@extends('template')

@section('title', 'All Posts')

@section('main')

<div class="container ws-container post-page">
    @if($latestPost)
    <div class="row">
        <div class="col post-col">
            <div class="position-relative">
                <img src="{{$latestPost->getPicture()}}" class="img-fluid w-100">

                <div class="post-content position-absolute p-4 w-100">
                    <h2>{{$latestPost->title}}</h2>
                    <div class="post-details d-flex align-items-center">
                        <span class="detail"><a href="{{$latestPost->user->getLink()}}">{{$latestPost->user->getFullName()}}</a></span>
                        <span class="detail">{{$latestPost->getUpdateDate()}}</span>
                        <span class="detail d-flex align-items-center">
                            <i class="fa fa-comment"></i>
                            <span>{{$latestPost->comments->count()}}</span>
                        </span>
                        <span class="d-flex detail align-items-center">
                            <i class="fa fa-heart"></i>
                            <span>{{$latestPost->likes->count()}}</span>
                        </span>
                    </div>
                    <div class="post-description">
                        <p>{{$latestPost->getShortBody()}}</p>
                    </div>

                    <a class="btn btn-default ws-button-link" href="{{$latestPost->getLink()}}">Read more</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="posts box-shadow-container position-relative">
        @if(!count($posts))
            <h2 class="section-title text-center">Looks like there is no posts to show</h2>
            @if(Auth::check())
                <a href="{{url('post/create')}}" class="btn btn-secondary ws-button-link position-absolute ws-absolute-position-link">Create Post</a>
            @endif
        @else
            <div class="row justify-content-center position-relative all-posts">
                <div class="col-12">
                    <h2 class="section-title text-center">All posts</h2>
                </div>
                @if(Auth::check())
                    <a href="{{url('post/create')}}" class="btn btn-secondary ws-button-link position-absolute ws-absolute-position-link">Create Post</a>
                @endif
                    <div id="post-example" class="col-12 col-lg-3 col-md-6 d-none">
                        <div class="d-flex flex-column post">

                            <div class="ws-img-container">
                                <img src="" class="img-fluid w-100 h-auto example-image">
                            </div>

                            <div class="post-container">
                                <div class="d-flex justify-content-between mb-3 post-details">
                                    <span class="example-date"></span>
                                    <span><a class="example-fullname" href=""></a></span>
                                </div>
                                <h3 class="post-title exmple-title"></h3>
                                <p class="post-description example-body"></p>
                            </div>
                            <div class="post-stats d-flex justify-content-around">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-eye"></i>
                                    <span class="example-view"></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-comment"></i>
                                    <span class="example-comment"></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-heart"></i>
                                    <span class="example-like"></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                <a class="post-link ws-button-link ws-button-yellow example-read-more">Read Post</a>
                            </div>
                        </div>
                    </div>

                @foreach($posts as $post)
                    <div class="col-12 col-lg-3 col-md-6 col-sm-10">
                        <div class="d-flex flex-column post visible-posts">

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
                            <div class="post-stats d-flex justify-content-around">
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
                            <div class="d-flex justify-content-center mt-2">
                                <a class="post-link ws-button-link ws-button-yellow" href="{{$post->getLink()}}">Read Post</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                <Button class="btn btn-secondary ws-button-link load-more">Load More</Button>
            </div>
        @endif
    </div>

</div>

@endsection
