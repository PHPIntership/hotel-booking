@extends('layouts.admin')
@section('title')
Admin Hotel
@endsection
@section('content')

<div class="row " id="example2">
<div class="col-md-12">
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('messages.admin_hotel') !!}</h3>
    </div>
    <div class="box-body">
        @include('layouts.admin.partials.flash')
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
                        {!! Former::open()->route('admin-hotel.edit',$adminHotel->id)->method('GET')->style('display: inline') !!}
                        <button type="submit"class="btn btn-info">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            {!! trans('messages.edit') !!}
                        </button>
                        {!! Former::close() !!}
                        {!! Former::open()->route('admin-hotel.destroy',$adminHotel->id)->method('Delete')->style('display: inline') !!}
                        <button onclick="return message('{!! trans('messages.delete_confirm') !!}')" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
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
<script src="{{asset('assets/js/message.js')}}"></script>
@endsection
