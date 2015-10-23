@extends('layouts.hotel')

@section('title')
{{trans('messages.hotel_room_type')}}
@endsection

@section('content')
<div class="row">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ trans('messages.hotel_room_type') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
            @include('layouts.hotel.partials.flash')
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>{!! trans('messages.room_type') !!}</th>
                    <th>{!! trans('messages.name') !!}</th>
                    <th>{!! trans('messages.quality') !!}</th>
                    <th>{!! trans('messages.quantity') !!}</th>
                    <th>{!! trans('messages.price') !!}</th>
                    <th>{!! trans('messages.description') !!}</th>
                    <th>{!! trans('messages.image') !!}</th>
                    <th>{!! trans('messages.action') !!}</th>
                </thead>
                <tbody>
                    @foreach($hotelRoomTypes as $key => $hotelRoomType)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$hotelRoomType->roomType->name}}</td>
                            <td>{{$hotelRoomType->name}}</td>
                            <td>{{$hotelRoomType->quality}}</td>
                            <td>{{$hotelRoomType->quantity}}</td>
                            <td>{{$hotelRoomType->price}}</td>
                            <td>{{$hotelRoomType->description}}</td>
                            <td>
                                <img src="{!! asset($hotelRoomType->image_link)  !!}" style="width:50px;height:50px;">
                            </td>
                            <td>
                                <a href="{!! route('hotel.room-type.edit',$hotelRoomType->id) !!}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    {{trans('messages.edit')}}
                                </a>

                                {!! Former::open()
                                    ->method('DELETE')
                                    ->action(route('hotel.room-type.destroy', $hotelRoomType->id))
                                    ->style('display:inline')
                                !!}
                                <button class="btn btn-danger" onclick="return message('{{trans('messages.delete_confirm')}}')">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    {{ trans('messages.delete') }}
                                </button>
                                {!! Former::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align:center">
                {!! $hotelRoomTypes->render() !!}
            </div>
        </div><!-- /.box-body -->
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/js/message.js')}}"></script>
@endsection
