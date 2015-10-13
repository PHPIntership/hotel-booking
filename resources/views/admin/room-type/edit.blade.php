@extends('layouts.admin')
@section('title')
    {{trans('messages.edit_room_type')}}
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.edit_room_type') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::vertical_open_for_files()
                        ->method('PUT')
                        ->file(true)
                        ->action(route('admin.room-type.update', $roomType->id))
                    !!}
                    @include('layouts.admin.partials.flash')
                    {!! Former::text('name')
                        ->placeholder(trans('messages.name'))
                        ->label(trans('messages.name'))
                        ->value($roomType->name)
                    !!}
                    {!! Former::text('quality')
                        ->placeholder(trans('messages.quality'))
                        ->label(trans('messages.quality'))
                        ->value($roomType->quality)
                    !!}
                    {!! Former::file('image')
                        ->accept('image')
                        ->label(trans('messages.image'))
                    !!}
                    {!! Former::submit(trans('messages.update'))->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
