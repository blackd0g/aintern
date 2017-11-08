@extends('layouts.default')

@section('content')
<div class="panel panel-primary">
 <div class="panel-heading">Show images</div>
  <div style="padding:30px;">
    <a href="/"><button class="btn btn-primary"><h5>Back to gallery</h5></button></a>
  </div>
  <div class="panel-body"> 
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <p class="error_item">{{ $error }}</p>
        @endforeach
    </div>
    @endif
    @if(!empty ( $image ))
    @foreach ($image as $img)
    <div class="row">
        <div class="col-md-12">
        <div class="col-md-12">    
            <h3><strong>Details</strong></h3>
            <h4>Name : {{ $img->real_name }}</h4>
            <h4>Thumbnail name : {{ $img->thumbnail_name }}</h4>
            <h4>Date upload : {{ $img->time }}</h4>
            <br>
        </div>
        <div class="col-md-4">
            <strong>Image Before Resize:</strong>
        </div>
        <div class="col-md-8">    
            <img src="{{asset('normal_images/'.$img->thumbnail_name) }}" /><br>
        </div>
        </div>
        <div class="col-md-12" style="margin-top:10px;">
        <div class="col-md-4">
            <strong>Image after Resize:</strong>
        </div>
        <div class="col-md-8">    
            @for ($i = 1; $i <= 5; $i++)
            size {{intval($img->width/$i)}} x {{intval($img->height/$i)}} <br>
                <img src="{{asset('thumbnail_images/size_'.$i.'/'.$img->thumbnail_name) }}" /><br>
            @endfor
        </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="row">
        <div class="col-md-12">
            <strong> Not found </strong>
        </div>
        </div>
    </div>
    @endif
 </div>
</div>
@endsection