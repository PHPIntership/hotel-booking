@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.edit_admin_hotel') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-8 col-md-offset-2">
                    {!! Former::vertical_open()
                        ->method('PUT')
                        ->action(route('admin-hotel.update', $adminHotel->id))
                    !!}
                    @include('admin.messages.success')
                    {!! Former::select('hotel_id')
                        ->options($hotels, $adminHotel->hotel_id)
                        ->label(trans('messages.hotel'))
                    !!}  
                    {!! Former::text('name')
                        ->placeholder('Real name')
                        ->label( trans('messages.name') )
                        ->value($adminHotel->name)
                    !!}
                    {!! Former::text('phone')
                        ->placeholder('Phone')
                        ->label(trans('messages.phone'))
                        ->value($adminHotel->phone)
                    !!}
                    {!! Former::submit('Update')->class('btn btn-info') !!}
                    {!! Former::close() !!}
                </div>
            </div><!-- /.box-body -->             
        </div>
    </div>
</div>

@endsection