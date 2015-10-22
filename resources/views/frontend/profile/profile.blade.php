@extends('layouts.frontend')
@section('title')
    {{trans('messages.profile')}}
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}">
@endsection
@section('content')
<div class="row">
<div id="content" class="container">
    <div class="row">
    <div class="container-fluid" id="profilepage">
        <div class="col-md-12">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist" id="navtab">
                    <li role="presentation" class="active">
                        <a href="#profle" aria-controls="home" role="tab" data-toggle="tab">{{ trans('messages.profile') }}</a>
                    </li>
                    <li role="presentation">
                        <a href="#orderhistory" aria-controls="tab" role="tab" data-toggle="tab">{{ trans('messages.order_history') }}</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="profle">
                        <div class="col-md-8 col-md-offset-2 registerform">
                            <div class="form-group formtitle">
                                <span class="label label-register">{{trans('messages.profile_infomation')}}</span>
                            </div>
                            <img src="{{$user->image_link}}" class="img-responsive userpic" alt="Image">
                            {!! Former::horizontal_open_for_files()
                                ->method('PUT')
                                ->action(route('user.profile'))
                            !!}
                            {!! Former::text('name')
                                ->label(trans('messages.name'))
                                ->value($user->name)
                            !!}
                            {!! Former::text('address')
                                ->label(trans('messages.address'))
                                ->value($user->address)
                            !!}
                            {!! Former::text('phone')
                                ->label(trans('messages.phone'))
                                ->value($user->phone)
                            !!}
                            {!! Former::file('image')
                                ->accept('image')
                                ->label(trans('messages.image'))
                                ->onchange("readURL(this);")
                            !!}
                            {!! Former::submit('Update')->class('btn btn-info update') !!}
                            {!! Former::close() !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane table-responsive" id="orderhistory">
                        <div class="col-md-8 col-md-offset-2 registerform">
                        <div class="form-group formtitle">
                            <span class="label label-register">{{ trans('messages.order_history') }}</span>
                        </div>
                    </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.hotel') }}</th>
                                    <th>{{ trans('messages.room_type') }}</th>
                                    <th>{{ trans('messages.coming_date') }}</th>
                                    <th>{{ trans('messages.leave_date') }}</th>
                                    <th>{{ trans('messages.quantity') }}</th>
                                    <th>{{ trans('messages.price') }}</th>
                                    <th>{{ trans('messages.status') }}</th>
                                    <th>{{ trans('messages.comment') }}</th>
                                    <th>{{ trans('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders  as $key => $order)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $order->hotelRoomType->hotel->name }}</td>
                                    <td>{{ $order->hotelRoomType->name }}</td>
                                    <td>{{ $order->coming_date }}</td>
                                    <td>{{ $order->leave_date }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->comment }}</td>
                                    <td>
                                        @if ($order->status == 0)
                                        {!! Former::open(route('user.order.cancel',$order->id))->method('post') !!}
                                        {!! Former::submit(trans('messages.cancel'))->class("btn btn-sm btn-warning cancel_order")!!}
                                        {!! Former::close() !!}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4" >{!! $orders->render() !!}</div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script>
window.location.hash = '#content';
@if (Session::has('tab'))
$(function(){
    $("#navtab a:last").tab('show');
});
@endif
@if (Session::has('flash_success'))
$(document).ready(function (){
    successMessage('Success', '{{Session::get('flash_success')}}');
})
@endif
$('.cancel_order').on('click', function () {
    var confirm = confirmMessage('{{trans('messages.cancel')}}','{{trans('messages.cancel_order_confirm')}}','{{trans('messages.yes')}}','{{trans('messages.no')}}',$(this));
});
</script>
<script src="{{asset('assets/js/alert.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
@endsection
