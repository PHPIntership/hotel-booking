@extends('layouts.admin')

@section('title')
Hotel management
@endsection

@section('content')
<div class="row">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ trans('messages.hotel_management') }}</h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
            @include('layouts.admin.partials.flash')
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>{!! trans('messages.city') !!}</th>
                    <th>{!! trans('messages.name') !!}</th>
                    <th>{!! trans('messages.quality').'(star)' !!}</th>
                    <th>{!! trans('messages.address') !!}</th>
                    <th>{!! trans('messages.image') !!}</th>
                    <th>{!! trans('messages.action') !!}</th>
                </thead>

                <tbody>
                    @foreach($hotels as $key => $hotel)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$hotel->city->name}}</td>
                            <td>{{$hotel->name}}</td>
                            <td>{{$hotel->quality}}</td>
                            <td>{{$hotel->address}}</td>
                            <td><img src="{!! asset('uploads/hotels/'.$hotel->image)  !!}" style="width:50px;height:50px;"></td>
                            <td>
                                {!! Former::open()
                                    ->method('GET')
                                    ->action(route('admin.hotels.edit', $hotel->id))
                                    ->style('display:inline')
                                !!}
                                {!! Former::submit(trans('messages.edit'))->class('btn btn-info') !!}
                                {!! Former::close() !!}

                                {!! Former::open()
                                    ->method('DELETE')
                                    ->action(route('admin.hotels.destroy', $hotel->id))
                                    ->style('display:inline')
                                !!}
                                <button class="btn btn-danger" onclick="return message('Do you want to delete?')">{{ trans('messages.delete') }}</button>
                                {!! Former::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align:center">
                {!! $hotels->render() !!}
            </div>
        </div><!-- /.box-body -->
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/js/message.js')}}"></script>
@endsection
