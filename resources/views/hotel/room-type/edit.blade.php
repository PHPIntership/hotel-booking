@extends('layouts.hotel')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.edit_hotel_room_type') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-6">
                    <img src="{{ asset('uploads/hotel-room-type/'.$hotelRoomType->image) }}" alt="hotel image" style="width:100%;height:100%" class="img-thumbnail">
                </div>
                <div class="col-md-6">
                    {!! Former::horizontal_open_for_files()
                        ->method('PUT')
                        ->action(route('hotel.room-type.update', $hotelRoomType->id))
                    !!}
                    @include('layouts.hotel.partials.flash')
                    {!! Former::text('name')
                        ->label(trans('messages.name'))
                        ->value($hotelRoomType->name)
                    !!}
                    {!! Former::text('quality')
                        ->label(trans('messages.quality'))
                        ->value($hotelRoomType->quality)
                    !!}
                    {!! Former::text('quantity')
                        ->label(trans('messages.quantity'))
                        ->value($hotelRoomType->quantity)
                    !!}
                    {!! Former::text('price')
                        ->label(trans('messages.price'))
                        ->value($hotelRoomType->price)
                    !!}
                    {!! Former::textarea('description')
                        ->label(trans('messages.description'))
                        ->value($hotelRoomType->description)
                        ->style('resize:none')
                    !!}
                    {!! Former::file('image')
                        ->accept('image')
                        ->label(trans('messages.image'))
                    !!}
                    {!! Former::submit('Update')->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
@endsection
