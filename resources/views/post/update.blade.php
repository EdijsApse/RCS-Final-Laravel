@extends('template')

@section('title', 'Update post - '.$post->title)

@section('main')

<div class="container ws-container">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-lg-6 form-container box-shadow-container">
            <h3 class="form-title text-center">Update {{$post->title}}</h3>
            <form class="ws-form" action="{{$post->getLink()}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <Label>Enter post title</Label>
                    <input type="text" name="title" data-min-length="5" value="{{(old('title') ? old('title') : $post->title)}}" class="ws-input" placeholder="Enter post title...">
                    <div class="error-message d-flex align-items-center {{($errors->first('title') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('title') ? $errors->first('title') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Enter post body</Label>
                    <div class="form-group">
                        <textarea name="body" data-min-length="10" placeholder="Enter post content. Dont be shy, write as much as you can..." class="ws-textarea">{{(old('body') ? old('body') : $post->body)}}</textarea>
                        <div class="error-message d-flex align-items-center {{($errors->first('body') ? "" : "hidden-error-message")}}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ ($errors->first('body') ? $errors->first('body') : "") }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Select post picture</Label>
                    <div class="ws-file-select-container">
                        <i class="fa fa-image"></i>
                        <label class="image-select-description" for="upload-photo">Choose picture</label>
                        <input type="file" name="picture" class="ws-file-select" />
                    </div>
                    @error('picture')
                    <div class="error-message d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn ws-button ws-button-secondary mb-4">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
