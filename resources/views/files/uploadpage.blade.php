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
    <div style="padding:30px;">
        <a href="/gallery/"><button class="btn btn-primary"><h5>Back to gallery</h5></button></a>
    </div>
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
    @if (Session::get('success'))
    
    <div class="row">
        <div class="col-md-12">
        <div class="col-md-4">
            <strong>Image Before Resize:</strong>
        </div>
        <div class="col-md-8">    
            <img src="{{asset('normal_images/'.Session::get('thumbnailName')) }}" />
        </div>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
        <div class="col-md-4">
            <strong>Image after Resize:</strong>
        </div>
        <div class="col-md-8">    
            @for ($i = 1; $i <= 5; $i++)
            size {{intval(Session::get('width_image')/$i)}} x {{intval(Session::get('height_image')/$i)}} <br>
                <img src="{{asset('thumbnail_images/size_'.$i.'/'.Session::get('thumbnailName')) }}" /><br>
            @endfor
        </div>
        </div>
    </div>
    @endif
 </div>
</div>
@endsection