@extends('layouts.hotel')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.create_hotel_room_type') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::vertical_open_for_files()
                        ->method('POST')
                        ->action(route('hotel.room-type.store'))
                    !!}
                    @include('layouts.hotel.partials.flash')
                    {!! Former::select('room_type_id')
                        ->placeholder(trans('messages.please_select'))
                        ->label('roomtype')
                        ->options($roomTypes)
                    !!}
                    {!! Former::text('name')
                        ->placeholder(trans('messages.name'))
                        ->label(trans('messages.name'))
                    !!}
                    {!! Former::text('quality')
                        ->placeholder(trans('messages.quality'))
                        ->label(trans('messages.quality'))
                    !!}
                    {!! Former::text('quantity')
                        ->placeholder(trans('messages.quantity'))
                        ->label(trans('messages.quantity'))
                    !!}
                    {!! Former::text('price')
                        ->placeholder(trans('messages.price'))
                        ->label(trans('messages.price'))
                    !!}
                    {!! Former::textarea('description')
                        ->placeholder(trans('messages.description'))
                        ->label(trans('messages.description'))
                    !!}
                    {!! Former::file('image')
                        ->accept('image')
                        ->label(trans('messages.image'))
                        ->style('resize:none')
                    !!}
                    {!! Former::submit('Create')->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
