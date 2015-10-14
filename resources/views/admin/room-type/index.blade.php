@extends('layouts.admin')
@section('title')
    {{trans('messages.room_type')}}
@endsection
@section('content')
<div class="row " id="example2">
<div class="col-md-12">
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('messages.room_type') !!}</h3>
    </div>
    <div class="box-body">
        @include('layouts.admin.partials.flash')
        <table class="table table-bordered table-striped" id="example1_wrapper">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{!! trans('messages.name') !!}</th>
                        <th>{!! trans('messages.quality') !!}</th>
                        <th>{!! trans('messages.image') !!}</th>
                        <th style="width:200px">{!! trans('messages.action') !!}</th>
                </thead>
                <tbody>
                @foreach ($roomTypes  as $key => $roomType)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $roomType->name }}</td>
                    <td>{{ $roomType->quality }}</td>
                    <td><img src="{{$roomType->image_link}}" alt="RoomType image" style="width:200px;height:auto" class="img-thumbnail room-type-image"></td>
                    <td>
                        <a href="{!! route('admin.room-type.edit',$roomType->id) !!}" class="btn btn-info">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            {!! trans('messages.edit') !!}
                        </a>
                        {!! Former::open()->route('admin.room-type.destroy',$roomType->id)->method('Delete')->style('display: inline') !!}
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
        <div class="col-sm-4" > {!! $roomTypes->render() !!} </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/message.js')}}"></script>
@endsection
