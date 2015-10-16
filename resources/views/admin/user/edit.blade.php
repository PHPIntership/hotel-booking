@extends('layouts.admin')
@section('title')
    {{trans('messages.edit_user')}}
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.edit_user') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::vertical_open_for_files()
                        ->method('PUT')
                        ->action(route('admin.user.update', $user->id))
                    !!}
                    @include('layouts.admin.partials.flash')
                    {!! Former::text('name')
                        ->placeholder(trans('messages.name'))
                        ->required()
                        ->value($user->name)
                        ->label(trans('messages.name'))
                    !!}
                    {!! Former::text()
                        ->placeholder(trans('messages.username'))
                        ->value($user->username)
                        ->readonly()
                        ->label(trans('messages.username'))
                    !!}
                    {!! Former::email()
                        ->placeholder(trans('messages.email'))
                        ->value($user->email)
                        ->readonly()
                        ->label(trans('messages.email'))
                    !!}
                    {!! Former::text('phone')
                        ->placeholder(trans('messages.phone'))
                        ->value($user->phone)
                        ->required()
                        ->label(trans('messages.phone'))
                    !!}
                    {!! Former::text('address')
                        ->placeholder(trans('messages.address'))
                        ->required()
                        ->value($user->address)
                        ->label(trans('messages.address'))
                    !!}
                    {!! Former::file('image')
                        ->accept('image')
                        ->label(trans('messages.image'))
                    !!}
                    {!! Former::submit(trans('messages.update'))
                        ->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@endsection
