@extends('layouts.admin')

@section('content')
  <h3 class="col-sm-offset-3 col-sm-7">Create new Hotel</h3>
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
  <form method="post" action="/admin/hotels" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="form-group">
      <label class="control-label col-sm-3">City</label>
      <div class="col-sm-5">
        <select class="form-control" name="city_id">
          <option value="1">Danang</option>
          <option value="2">Hanoi</option>
          <option value="3">HCM city</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">Name</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="name" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">Quality</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="quality" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">Address</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="address" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">Email</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="email" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">Phone</label>
      <div class="col-sm-5">
        <input class="form-control" type="text" name="phone" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3">Description</label>
      <div class="col-sm-5">
        <textarea class="form-control" name="description"
        style="resize:none"></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-5">
        <input class="btn btn-default" type="submit" value="submit" />
      </div>
    </div>
  </form>
@endsection
