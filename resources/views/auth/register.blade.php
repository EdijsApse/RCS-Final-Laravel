@extends('template')

@section('title', 'Create Account')


@section('main')

<div class="container ws-container">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-lg-6 form-container">
            <h3 class="form-title text-center">Create Account</h3>
            <form class="ws-form" action="{{route('register')}}" method="post">
                @csrf
                <div class="form-group">
                    <Label>Your Name</Label>
                    <input type="text" data-min-length="4" name="name" value="{{ old('name') }}" class="ws-input" placeholder="Enter your name...">
                    <div class="error-message d-flex align-items-center {{($errors->first('name') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('name') ? $errors->first('name') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Your Surname</Label>
                    <input type="text" name="surname" data-min-length="4" value="{{ old('surname') }}" class="ws-input" placeholder="Enter your surname...">
                    <div class="error-message d-flex align-items-center {{($errors->first('surname') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('surname') ? $errors->first('surname') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Enter your Email address</Label>
                    <input type="text" name="email" data-email="true" class="ws-input" value="{{ old('email') }}" placeholder="Enter your email address...">
                    <div class="error-message d-flex align-items-center {{($errors->first('email') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('email') ? $errors->first('email') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Password</Label>
                    <input class="ws-input" data-min-length="4" name="password" type="password" placeholder="Enter password...">
                    <div class="error-message d-flex align-items-center {{($errors->first('password') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('password') ? $errors->first('password') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Confirm password</Label>
                    <input class="ws-input" data-password-confirm="true" name="password_confirmation" type="password" placeholder="Enter same password as above...">
                    <div class="error-message d-flex align-items-center hidden-error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p></p>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn ws-button ws-button-secondary">Register</button>
                </div>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-secondary ws-button-link" href="{{route('login')}}">Login</a>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
