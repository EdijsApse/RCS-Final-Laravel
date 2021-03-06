@extends('template')

@section('title', $user->getFullname())

@section('main')

<div class="container-fluid ws-container user-page">
    <div class="user-view-page">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-12">
                <div class="user-details">
                    <div class="d-flex justify-content-center">
                        <div class="d-flex flex-column">
                            <h1>{{$user->getFullname()}}</h1>
                            <div class="user-image">
                                <img src="{{asset($user->getProfilePicture())}}" class="img-fluid">
                            </div>
                        </div>
                        @if($user->id == Auth::id())
                            <a href="{{url('profile/edit')}}" class="btn btn-secondary ws-button-link position-absolute"><span>Edit Profile</span><i class="fa fa-cog d-none"></i></a>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center user-stat w-100">
                        <div class="stat">
                            <h4>Viewed posts</h4>
                            <i class="fa fa-eye"></i>
                            <p>{{$user->viewedPosts->count()}}</p>
                        </div>
                        <div class="stat">
                            <h4>Posts created</h4>
                            <i class="fa fa-scroll"></i>
                            <p>{{$user->posts->count()}}</p>
                        </div>
                        <div class="stat">
                            <h4>Comments created</h4>
                            <i class="fa fa-comment"></i>
                            <p>{{$user->comments->count()}}</p>
                        </div>
                        <div class="stat">
                            <h4>Profile views</h4>
                            <i class="fa fa-eye"></i>
                            <p>{{$user->profileViews->count()}}</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12">
                        <h2 class="section-title text-center">Users posts</h2>
                    </div>
                    @foreach($user->posts as $post)
                        <div class="col-12 col-lg-3 col-md-6 col-sm-8">
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
            </div>
        </div>
    </div>
</div>

@endsection
