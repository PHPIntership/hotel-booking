@extends('layouts.admin')

@section('content')
<h3 class="col-sm-offset-3 col-sm-7">{{trans('admin/hotels.hr_edit')}}</h3>
<div class="row">
  @if ( session()->has('edit_success') )
  <div class="col-sm-offset-3 col-sm-5 alert alert-success">
      <ul>
        {{session('edit_success')}}
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
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_city')}}</label>
    <div class="col-sm-5">
      <select class="form-control" name="city_id" >
        @foreach ($cities as $city)
          <option value="{{$city->id}}" {{$city_id == $city->id? "selected" : ""}}>{{$city->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_name')}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="name" value="{{$name}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_quality')}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="quality" value="{{$quality}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_address')}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="address" value="{{$address}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_email')}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="email" value="{{$email}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_phone')}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="phone" value="{{$phone}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_website')}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="text" name="website" value="{{$website}}"/>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_image')}}</label>
    <div class="col-sm-5">
      <input class="form-control" type="file" accept="image/*" name="image" />
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-3">{{trans('admin/hotels.th_description')}}</label>
    <div class="col-sm-5">
      <textarea class="form-control" name="description"
      style="resize:none">{{$description}}</textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-5">
      <input class="btn btn-default" type="submit" value="{{trans('admin/hotels.edit_submit')}}"/>
    </div>
  </div>
</form>
@endsection
