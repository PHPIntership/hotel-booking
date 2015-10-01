@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.create_admin_hotel') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::vertical_open()
                        ->method('POST')
                        ->action(route('admin-hotel.store'))
                    !!}
                    @include('admin.messages.success')
                    {!! Former::select('hotel_id')
                    ->options($hotels)
                    ->label(trans('messages.hotel'))
                    !!}
                    {!! Former::text('username')
                    ->placeholder('Username')
                    ->label(trans('messages.username'))
                    !!}
                    {!! Former::password('password')
                    ->placeholder('******')
                    ->label(trans('messages.password'))
                    !!}
                    {!! Former::text('name')
                    ->placeholder('Real name')
                    ->label(trans('messages.name'))
                    !!}
                    {!! Former::email('email')
                    ->placeholder('Email@.gmail.com')
                    ->label(trans('messages.email'))
                    !!}
                    {!! Former::text('phone')
                    ->placeholder('Phone')
                    ->label(trans('messages.phone'))
                    !!}
                    {!! Former::submit('Create')->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->             
        </div>
    </div>
</div>

@endsection



