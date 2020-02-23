@extends('template')

@section('title', 'My Profile')


@section('main')

<div class="container ws-container">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-lg-6 form-container">
            <h3 class="form-title text-center">{{$user->getFullname()}}</h3>
            <form class="ws-form" action="{{url('profile')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <Label>Your Name</Label>
                    <input type="text" name="name" value="{{ (old('name') ? old('name') : $user->name ) }}" class="ws-input" placeholder="Enter your name...">
                    @error('name')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Your Surname</Label>
                    <input type="text" name="surname" value="{{ (old('surname') ? old('surname') : $user->surname ) }}" class="ws-input" placeholder="Enter your surname...">
                    @error('surname')
                        <div class="error-message d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Enter your Email address</Label>
                    <input type="text" name="email" class="ws-input" value="{{ (old('email') ? old('email') : $user->email ) }}" placeholder="Enter your email address...">
                    @error('email')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Select your profile picture</Label>
                    <div class="ws-file-select-container">
                        <i class="fa fa-image"></i>
                        <label for="upload-photo">Choose picture</label>
                        <input type="file" name="picture" class="ws-file-select" />
                    </div>
                    @error('picture')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <button type="submit" class="btn ws-button ws-button-secondary">Update Profile</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection