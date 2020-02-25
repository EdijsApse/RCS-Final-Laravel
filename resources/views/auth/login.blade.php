@extends('template')

@section('title', 'Login')

@section('main')

<div class="container ws-container">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-lg-6 form-container box-shadow-container">
            <h3 class="form-title text-center">Sign In</h3>
            <form class="ws-form" action="{{route('login')}}" method="post">
                @csrf
                <div class="form-group">
                    <Label>Your email address</Label>
                    <input type="text" data-email="true" name="email" class="ws-input" placeholder="Enter your email address...">
                    <div class="error-message d-flex align-items-center {{($errors->first('email') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('email') ? $errors->first('email') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Enter your password</Label>
                    <input type="password" data-min-length="4" name="password" class="ws-input" placeholder="Enter your password...">
                    <div class="error-message d-flex align-items-center {{($errors->first('password') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('password') ? $errors->first('password') : "") }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn ws-button ws-button-secondary">Login</button>
                </div>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-secondary ws-button-link" href="{{route('register')}}">Create account</a>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
