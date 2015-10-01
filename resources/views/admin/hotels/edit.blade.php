@extends('layouts.admin')

@section('content')
<h3 class="col-sm-offset-3 col-sm-7">{{$hr_edit}}</h3>
<div class="row">
  @if ( session()->has('msg') )
  <div class="col-sm-offset-3 col-sm-5 alert alert-success">
      <ul>
        {{session('msg')}}
      </ul>
  </div>
  @endif
  @if ( $errors->any() )
  <div class="col-sm-offset-3 col-sm-5 alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
  </div>
  @endif
</div>
<form method="post" action="/admin/hotels/{{$id}}" class="form-horizontal" enctype="multipart/form-data">
  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  <input type="hidden" name="_method" value="put" />
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_city}}</label>
    <div class="col-sm-5">
      <select class="form-control" name="city_id" >
        @foreach ($cities as $key => $value)
          <option value="{{$key}}" {{$city_id == $key? "selected" : ""}}>{{$value}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_name}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="name" value="{{$name}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_quality}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="quality" value="{{$quality}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_address}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="address" value="{{$address}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_email}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="email" value="{{$email}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_phone}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="phone" value="{{$phone}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_website}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="website" value="{{$website}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_image}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="file" accept="image/*" name="image" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{$th_description}}</label>
    <div class="col-sm-5">
      <textarea class="form-control" name="description"
      style="resize:none">{{$description}}</textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-5">
      <input class="btn btn-default" type="submit" value="{{$bn_submit}}"/>
    </div>
  </div>
</form>
@endsection
