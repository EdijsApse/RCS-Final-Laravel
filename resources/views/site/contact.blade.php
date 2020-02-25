@extends('template')

@section('title', 'Contact Us')

@section('main')

<div class="container ws-container contact-page bg-white ws-section-padding box-shadow-container">
    <h2 class="section-title text-center">Contact Me</h2>
    <div class="row align-items-center contact-row">
        <div class="col-12 col-lg-6 col-md-10">
            <div class="map-container">
                <div class="map box-shadow-container">
                    <iframe  id="gmap_canvas" src="https://maps.google.com/maps?q=Riga%20Coding%20School&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-md-10 contact-form-container">
            <form class="ws-form box-shadow-container py-4 px-5" action="{{url('contact')}}" method="post">
                @csrf
                <div class="form-group">
                    <Label>Your name</Label>
                    <input type="text" data-min-length="4" autocomplete="off" value="{{old('name')}}" name="name" class="ws-input" placeholder="Enter your name...">
                    <div class="error-message d-flex align-items-center {{($errors->first('name') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('name') ? $errors->first('name') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Your email address</Label>
                    <input type="text" data-email="true" autocomplete="off" value="{{old('email')}}" name="email" class="ws-input" placeholder="Enter your email address...">
                    <div class="error-message d-flex align-items-center {{($errors->first('email') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('email') ? $errors->first('email') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Enter post body</Label>
                    <div class="form-group">
                        <textarea name="body" data-min-length="10" placeholder="Enter post content. Dont be shy, write as much as you can..." class="ws-textarea">{{old('body')}}</textarea>
                        <div class="error-message d-flex align-items-center {{($errors->first('body') ? "" : "hidden-error-message")}}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ ($errors->first('email') ? $errors->first('body') : "") }}</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn ws-button ws-button-secondary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

