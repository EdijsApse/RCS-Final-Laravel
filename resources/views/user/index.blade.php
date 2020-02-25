@extends('template')

@section('title', 'All Posts')

@section('main')

<div class="container ws-container user-page box-shadow-container pt-3">
    <div class="posts">
        @if(!count($users))
            <h2 class="section-title text-center">Looks like there is no users except You!</h2>
        @else
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="section-title text-center">All users</h2>
                </div>
                @foreach($users as $user)
                    <div class="col-12 col-lg-3 col-md-6 col-sm-8">
                        <div class="d-flex flex-column post position-relative">
                            <div class="ws-img-container">
                                <img src="{{$user->getProfilePicture()}}" class="img-fluid w-100 h-auto">
                            </div>
                            <div class="user-container">
                                <h3 class="text-center"><a href="{{$user->getLink()}}">{{$user->getFullname()}}</a></h3>
                                <div class="user-statistic d-flex justify-content-between">
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
                                <p class="text-center">{{$user->getRegistrationDate()}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
