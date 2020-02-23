@extends('template')

@section('title', 'Login')

@section('main')

<div class="container ws-container">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-lg-6 form-container">
            <h3 class="form-title text-center">Sign In</h3>
            <form class="ws-form" action="{{route('login')}}" method="post">
                @csrf
                <div class="form-group">
                    <Label>Your email address</Label>
                    <input type="text" name="email" class="ws-input" placeholder="Enter your email address...">
                    @error('email')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Enter your password</Label>
                    <input type="password" name="password" class="ws-input" placeholder="Enter your password...">
                    @error('password')
                        <div class="error-message d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
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
