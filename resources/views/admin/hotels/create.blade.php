@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.create_hotel') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::horizontal_open()
                        ->method('POST')
                        ->action(route('admin.hotels.store'))
                    !!}
                    @include('layouts.admin.partials.flash')
                    {!! Former::select('city_id')
                        ->options($cities)
                        ->label(trans('messages.city'))
                    !!}
                    {!! Former::text('name')
                        ->label( trans('messages.name') )
                    !!}
                    {!! Former::text('quality')
                        ->label( trans('messages.quality') )
                    !!}
                    {!! Former::text('address')
                        ->label( trans('messages.address') )
                    !!}
                    {!! Former::text('email')
                        ->label( trans('messages.email') )
                    !!}
                    {!! Former::text('phone')
                        ->label(trans('messages.phone'))
                    !!}
                    {!! Former::textarea('description')
                        ->label(trans('messages.description'))
                        ->style('resize:none')
                    !!}
                    {!! Former::submit(trans('messages.create_submit'))->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
