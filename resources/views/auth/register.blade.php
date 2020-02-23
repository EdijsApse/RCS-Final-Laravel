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
                    <input type="text" name="name" value="{{ old('name') }}" class="ws-input" placeholder="Enter your name...">
                    @error('name')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Your Surname</Label>
                    <input type="text" name="surname" value="{{ old('surname') }}" class="ws-input" placeholder="Enter your surname...">
                    @error('surname')
                        <div class="error-message d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Enter your Email address</Label>
                    <input type="text" name="email" class="ws-input" value="{{ old('email') }}" placeholder="Enter your email address...">
                    @error('email')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Password</Label>
                    <input class="ws-input" name="password" type="password" placeholder="Enter password...">
                    @error('password')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Confirm password</Label>
                    <input class="ws-input" name="password_confirmation" type="password" placeholder="Enter same password as above...">
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
