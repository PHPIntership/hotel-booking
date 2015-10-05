@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.edit_hotel') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::horizontal_open()
                        ->method('PUT')
                        ->action(route('admin.hotels.update', $hotel->id))
                    !!}
                    @include('layouts.admin.partials.flash')
                    {!! Former::select('city_id')
                        ->options($cities, $hotel->city_id)
                        ->label(trans('messages.city'))
                    !!}
                    {!! Former::text('name')
                        ->label( trans('messages.name') )
                        ->value($hotel->name)
                    !!}
                    {!! Former::text('quality')
                        ->label( trans('messages.quality') )
                        ->value($hotel->quality)
                    !!}
                    {!! Former::text('address')
                        ->label( trans('messages.address') )
                        ->value($hotel->address)
                    !!}
                    {!! Former::text('email')
                        ->label( trans('messages.email') )
                        ->value($hotel->email)
                    !!}
                    {!! Former::text('phone')
                        ->label(trans('messages.phone'))
                        ->value($hotel->phone)
                    !!}
                    {!! Former::text('website')
                        ->label(trans('messages.website'))
                        ->value($hotel->website)
                    !!}
                    {!! Former::file('image')
                        ->accept('image')
                        ->label(trans('messages.image'))
                    !!}
                    {!! Former::textarea('description')
                        ->label(trans('messages.description'))
                        ->value($hotel->description)
                        ->style('resize:none')
                    !!}
                    {!! Former::submit(trans('messages.edit_submit'))->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
