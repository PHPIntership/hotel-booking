@extends('layouts.admin')
@section('title')
Admin Hotel
@endsection
@section('content')

<div class="row " id="example2">
  @if (Session::has('flash_message'))
     <div class="alert alert-success">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <strong>Success!</strong>
         {{ Session::get('flash_message') }}
     </div>
@endif
<div class="col-md-12">
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('messages.admin_hotel') !!}</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped" id="example1_wrapper">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>{!! trans('messages.hotel') !!}</th>
                      <th>{!! trans('messages.username') !!}</th>
                      <th>{!! trans('messages.name') !!}</th>
                      <th>{!! trans('messages.email') !!}</th>
                      <th>{!! trans('messages.phone') !!}</th>
                      <th>{!! trans('messages.action') !!}</th>
                  </tr>
              </thead>
              <tbody>
              @foreach ($adminHotels  as $key => $adminHotel)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $adminHotel->hotel->name }}</td>
                    <td>{{ $adminHotel->username }}</td>
                    <td>{{ $adminHotel->name }}</td>
                    <td>{{ $adminHotel->email }}</td>
                    <td>{{ $adminHotel->phone }}</td>
                    <td>
                      {!! Former::open()->route('admin-hotel.destroy',$adminHotel->id)->method('Delete') !!}
                      <button onclick="return messenge('{!! trans('messages.table_tittle.delete_confirm') !!}')" class="btn btn-danger">
                          <i class="fa fa-pencil"></i>
                          {!! trans('messages.delete') !!}
                      </button>
                      {!! Former::close() !!}
                    </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
        </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-4" > {!! $adminHotels->render() !!} </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script src="{{asset('bower_components/AdminLTE/dist/js/msg.js')}}"></script>
@endsection
