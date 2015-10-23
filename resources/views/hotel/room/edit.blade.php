@extends('layouts.hotel')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.edit_room') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::horizontal_open()
                        ->method('PUT')
                        ->action(route('hotel.room.update', $room->id))
                    !!}
                    @include('layouts.admin.partials.flash')
                    {!! Former::select('hotel_room_type_id')
                        ->options($hotelRoomTypes, $room->hotel_room_type_id)
                        ->label(trans('messages.hotel_room_type'))
                    !!}
                    {!! Former::text('name')
                        ->label( trans('messages.name') )
                        ->value($room->name)
                    !!}
                    {!! Former::select('status')
                        ->options([
                            0 => trans('messages.status_0'),
                            1 => trans('messages.status_1'),
                            2 => trans('messages.status_2'),
                            ], $room->status)
                        ->label(trans('messages.status'))
                    !!}
                    {!! Former::submit(trans('messages.edit_submit'))->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
