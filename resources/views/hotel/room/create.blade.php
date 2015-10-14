@extends('layouts.hotel')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.create_room') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::horizontal_open()
                        ->method('POST')
                        ->action(route('hotel.room.store'))
                    !!}
                    @include('layouts.admin.partials.flash')
                    {!! Former::select('hotel_room_type_id')
                        ->options($hotelRoomTypes)
                        ->label(trans('messages.hotel_room_type'))
                    !!}
                    {!! Former::text('name')
                        ->label( trans('messages.name') )
                    !!}
                    {!! Former::hidden('status')
                        ->value(0) 
                    !!}
                    {!! Former::submit(trans('messages.create_submit'))->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
