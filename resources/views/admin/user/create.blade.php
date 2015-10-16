@extends('layouts.admin')
@section('title')
    {{trans('messages.create_user')}}
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.create_user') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::vertical_open_for_files()
                        ->method('POST')
                        ->action(route('admin.user.store'))
                    !!}
                    @include('layouts.admin.partials.flash')
                    {!! Former::text('name')
                        ->placeholder(trans('messages.name'))
                        ->required()
                        ->label(trans('messages.name'))
                    !!}
                    {!! Former::text('name')
                        ->placeholder(trans('messages.username'))
                        ->required()
                        ->label(trans('messages.username'))
                    !!}
                    {!! Former::text('password')
                        ->placeholder(trans('messages.password'))
                        ->required()
                        ->label(trans('messages.password'))
                    !!}
                    {!! Former::email('email')
                        ->placeholder(trans('messages.email'))
                        ->required()
                        ->label(trans('messages.email'))
                    !!}
                    {!! Former::text('phone')
                        ->placeholder(trans('messages.phone'))
                        ->required()
                        ->label(trans('messages.phone'))
                    !!}
                    {!! Former::text('address')
                        ->placeholder(trans('messages.address'))
                        ->required()
                        ->label(trans('messages.address'))
                    !!}
                    {!! Former::file('image')
                        ->accept('image')
                        ->label(trans('messages.image'))
                    !!}
                    {!! Former::submit(trans('messages.create'))
                        ->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
