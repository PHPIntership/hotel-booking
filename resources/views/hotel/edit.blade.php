@extends('layouts.hotel')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.edit_hotel') }}</h3>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <img src="{{ asset('uploads/hotel/'.$hotel->image) }}" alt="hotel image" style="width:100%;height:100%" class="img-thumbnail">
                </div>
                <div class="col-md-6">
                    @include('layouts.hotel.partials.flash')
                    {!! Former::vertical_open_for_files()
                        ->action(route('hotel.profile'))
                        ->method('post')
                    !!}
                    {!! Former::text('website')
                        ->label( trans('messages.website') )
                        ->value($hotel->website)
                    !!}
                    {!! Former::text('phone')
                        ->label(trans('messages.phone'))
                        ->value($hotel->phone)
                    !!}
                    {!! Former::text('description')
                        ->label(trans('messages.description'))
                        ->value($hotel->description)
                    !!}
                    {!! Former::file('image')
                        ->label(trans('messages.image'))
                    !!}
                    {!! Former::submit(trans('messages.update'))
                        ->class('btn btn-info')
                    !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
@endsection
