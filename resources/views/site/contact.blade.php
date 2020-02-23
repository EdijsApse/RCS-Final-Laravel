@extends('template')

@section('title', 'Contact Us')

@section('main')

<div class="container ws-container bg-white ws-section-padding">
    <h2 class="section-title text-center">Contact Me</h2>
    <div class="row align-items-center">
        <div class="col-12 col-lg-6">
            <div class="map-container">
                <div class="map">
                    <iframe  id="gmap_canvas" src="https://maps.google.com/maps?q=Riga%20Coding%20School&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 contact-form-container">
            <form class="ws-form" action="{{url('contact')}}" method="post">
                @csrf
                <div class="form-group">
                    <Label>Your name</Label>
                    <input type="text" value="{{old('name')}}" name="name" class="ws-input" placeholder="Enter your name...">
                    @error('name')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Your email address</Label>
                    <input type="text" value="{{old('email')}}" name="email" class="ws-input" placeholder="Enter your email address...">
                    @error('email')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <Label>Enter post body</Label>
                    <div class="form-group">
                        <textarea name="body" placeholder="Enter post content. Dont be shy, write as much as you can..." class="ws-textarea">{{old('body')}}</textarea>
                    </div>
                    @error('body')
                        <div class="error-message d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn ws-button ws-button-secondary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

