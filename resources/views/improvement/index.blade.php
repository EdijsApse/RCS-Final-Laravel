<?php

    use App\Improvement;

?>
@extends('template')

@section('title', 'Improvements')

@section('main')

<div class="container ws-container improvement-page bg-white ws-section-padding box-shadow-container position-relative">
    <h2 class="section-title text-center">Improvements</h2>
    <button class="btn btn-secondary ws-button-link position-absolute ws-absolute-position-link mt-2" data-toggle="modal" data-target="#createImprovementModal">Add improvement</button>
    <div class="row">
        @foreach (Improvement::getStatuses() as $improvementDetail)
            <div class="col-4">
                <div class="improvement-section py-2" data-status="{{$improvementDetail['status']}}">
                    <h3 class="text-center">{{$improvementDetail['title']}}</h3>
                    @foreach ($improvements->filterByStatus($improvementDetail['status'])->sortByDesc('priority') as $improvement)
                    <div class="position-relative improvement box-shadow-container m-2" draggable="true" data-id="{{$improvement->id}}">
                        <div class="position-absolute priority" data-toggle="tooltip" title="Priority: {{$improvement->getPriority()}}">
                            <i class="fa fa-fire {{strtolower($improvement->getPriority())}}"></i>
                        </div>
                        <div class="d-flex flex-row align-items-center improvement-header">
                            <div class="improvement-user-image">
                                <img src="{{$improvement->getUserPicture()}}" class="" />
                            </div>
                            <div class="improvement-header-content">
                                <h5 class="text-center">{{$improvement->title}}</h5>
                                <h6>{{$improvement->getUserName()}}</h6>
                            </div>
                        </div>
                        <div class="improvement-details">
                            <div class="description">
                                <p>{{$improvement->description}}</p>
                            </div>
                            <div class="date d-flex justify-content-between align-items-center improvement-icons">
                                <span class="icon d-flex align-items-center"><i class="fa fa-clock"></i>{{($improvement->created_at == $improvement->updated_at ? "Created" : "Updated")}} </span>
                                <span>{{$improvement->getUpdateTime()}}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="modal fade ws-modal" id="createImprovementModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content position-relative">
            <div class="d-flex justify-content-center w-100 text-center mt-3">
                <h2>Add new improvement</h2>
            </div>
            <button type="button" class="close position-absolute" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times-circle"></i>
            </button>
        <div class="modal-body pt-0">
            <form class="ws-form" method="post" action="/improvement">
                @csrf
                <div class="form-group">
                    <Label>Improvement title</Label>
                    <input type="text" data-min-length="4" value="{{(old('title') ? old('title') : "")}}" autocomplete="off" name="title" class="ws-input" placeholder="Enter improvement title...">
                    <div class="error-message d-flex align-items-center {{($errors->first('title') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('title') ? $errors->first('title') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Priority</Label>
                    <div class="d-flex justify-content-between">
                        @foreach (Improvement::getPriorities() as $value => $priority)
                            <div class="form-check d-flex align-items-center pl-0">
                                <input class="form-check-input" type="radio" name="priority" value="{{$value}}" {{(!$value ? "checked" : "")}}>
                                <div class="ws-radio-container">
                                    <div class="checked"></div>
                                </div>
                                <label class="form-check-label mb-0 ml-2">{{$priority}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="error-message d-flex align-items-center {{($errors->first('priority') ? "" : "hidden-error-message")}}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>{{ ($errors->first('priority') ? $errors->first('priority') : "") }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <Label>Improvement description</Label>
                    <div class="form-group">
                        <textarea name="description" data-min-length="10" placeholder="If you think you have some idea that will improve this project, feel free to describe it..." class="ws-textarea">{{(old('description') ? old('description') : "")}}</textarea>
                        <div class="error-message d-flex align-items-center {{($errors->first('description') ? "" : "hidden-error-message")}}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ ($errors->first('description') ? $errors->first('description') : "") }}</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn ws-button ws-button-secondary">Save</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
<script src="/js/improvement.js"></script>
@endsection
