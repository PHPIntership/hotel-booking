@extends('layouts.admin')

@section('content')
  <h3 class="col-sm-offset-3 col-sm-7">{{trans('admin/hotels.hr_create')}}</h3>
  <div class="row">
    @if ( session()->has('create_success') )
    <div class="col-sm-offset-3 col-sm-5 alert alert-success">
        <ul>
          {{session('create_success')}}
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
  <form method="post" action="/admin/hotels" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="form-group">
      <label class="control-label col-sm-3">{{trans('admin/hotels.th_city')}}</label>
      <div class="col-sm-5">
        <select class="form-control" name="city_id">
          @foreach ($cities as $city)
            <option value="{{$city->id}}">{{$city->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">{{trans('admin/hotels.th_name')}}</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="name" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">{{trans('admin/hotels.th_quality')}}</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="quality" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">{{trans('admin/hotels.th_address')}}</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="address" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">{{trans('admin/hotels.th_email')}}</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="email" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">{{trans('admin/hotels.th_phone')}}</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="phone" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">{{trans('admin/hotels.th_description')}}</label>
      <div class="col-sm-5">
        <textarea class="form-control" name="description"
        style="resize:none"></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-5">
        <input class="btn btn-default" type="submit" value="{{trans('admin/hotels.create_submit')}}" />
      </div>
    </div>
  </form>
@endsection
