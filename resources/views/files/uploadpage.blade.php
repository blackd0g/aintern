@extends('layouts.default')
@section('content')
<div class="panel panel-primary">
 <div class="panel-heading">Laravel Intervention upload image after resize</div>
  <div class="panel-body"> 
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <p class="error_item">{{ $error }}</p>
        @endforeach
    </div>
    @endif
    @if (Session::get('success'))
    
    <div class="row">
        <div class="col-md-12">
        <div class="col-md-4">
            <strong>Image Before Resize:</strong>
        </div>
        <div class="col-md-8">    
            <img src="{{asset('normal_images/'.Session::get('imagename')) }}" />
        </div>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
        <div class="col-md-4">
            <strong>Image after Resize:</strong>
        </div>
        <div class="col-md-8">    
            <img src="{{asset('thumbnail_images/'.Session::get('imagename')) }}" />
        </div>
        </div>
    </div>
    @endif
    {!! Form::open(array('route' => 'intervention.postresizeimage','files'=>true)) !!}
        <div class="row">
        
            <div class="col-md-6">
                <br/>
                {!! Form::file('photo', array('class' => 'form-control')) !!}
            </div>
            <div class="col-md-6">
                <br/>
                <button type="submit" class="btn btn-primary">Upload Image</button>
            </div>
        </div>
    {!! Form::close() !!}
 </div>
</div>
@endsection