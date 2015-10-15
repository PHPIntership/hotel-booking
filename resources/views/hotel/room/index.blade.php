@extends('layouts.admin')

@section('title')
Hotel management
@endsection

@section('content')
<div class="row">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ trans('messages.room_management') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
            @include('layouts.admin.partials.flash')
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>{!! trans('messages.hotel_room_type') !!}</th>
                    <th>{!! trans('messages.name') !!}</th>
                    <th>{!! trans('messages.status') !!}</th>
                    <th>{!! trans('messages.action') !!}</th>
                </thead>

                <tbody>
                    @foreach($rooms as $key => $room)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$room->hotelRoomType->name}}</td>
                            <td>{{$room->name}}</td>
                            <td>{{trans('messages.status_'.$room->status)}}</td>
                            <td>
                                <a class="btn btn-info" name="button" href='{{ route('hotel.room.edit', $room->id)}}'>{{trans('messages.edit')}}</a>

                                {!! Former::open()
                                    ->method('DELETE')
                                    ->action(route('hotel.room.destroy', $room->id))
                                    ->style('display:inline')
                                !!}
                                <button class="btn btn-danger" onclick="return message('{{trans('messages.delete_confirm')}}')">{{ trans('messages.delete') }}</button>
                                {!! Former::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align:center">
                {!! $rooms->render() !!}
            </div>
        </div><!-- /.box-body -->
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/js/message.js')}}"></script>
@endsection
