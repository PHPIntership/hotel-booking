@extends('layouts.hotel')
@section('title')
Booking Manage
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}">
@endsection
@section('content')

<div class="row " id="example2">
    <div class="col-md-12">
        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{!! trans('messages.booking_manage') !!}</h3>
        </div>
        <div class="box-body">
            @include('layouts.hotel.partials.flash')
            <table class="table table-bordered table-striped" id="example1_wrapper">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>order id</th>
                            <th>User</th>
                            <th>Room type</th>
                            <th>quantity</th>
                            <th>coming date</th>
                            <th>leave date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders  as $key => $order)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->hotelRoomType->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->coming_date }}</td>
                            <td>{{ $order->leave_date }}</td>
                            <td>
                                <label style="font-size:13px" class="label label-{{$label[$order->status]}}">
                                {{ trans('messages.status_order_'.$order->status) }}
                                </label>
                            </td>
                            <td>
                                @if ($order->status == 0)
                                    {!! Former::open(route('hotel.booking-manage.accept',$order->id))->method('post')->style('display: inline') !!}
                                        {!! Former::button(trans('messages.accept'))->class("btn btn-sm btn-info accept-order")!!}
                                    {!! Former::close() !!}
                                    {!! Former::open(route('hotel.booking-manage.decline',$order->id))->method('post')->style('display: inline') !!}
                                        {!! Former::button(trans('messages.decline'))->class("btn btn-sm btn-warning decline-order") !!}
                                    {!! Former::close() !!}
                                @elseif ($order->status == 1)
                                    {!! Former::open(route('hotel.booking-manage.cancel',$order->id))->method('post')->style('display: inline') !!}
                                        {!! Former::button(trans('messages.cancel'))->class("btn btn-sm btn-warning cancel-order")!!}
                                    {!! Former::close() !!}
                                @elseif ($order->status == 3)
                                    {!! Former::open(route('hotel.booking-manage.destroy',$order->id))->method('delete')->style('display: inline') !!}
                                        {!! Former::button(trans('messages.delete'))->class("btn btn-sm btn-danger delete-order") !!}
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
@endsection
@section('js')
<script>
$('.delete-order').on('click', function () {
    var confirm = confirmMessage('{{trans('messages.delete')}}','{{trans('messages.delete_order_confirm')}}','{{trans('messages.yes')}}','{{trans('messages.no')}}',$(this));
});
$('.accept-order').on('click', function () {
    var confirm = confirmMessage('{{trans('messages.accept')}}','{{trans('messages.accept_order_confirm')}}','{{trans('messages.yes')}}','{{trans('messages.no')}}',$(this));
});
$('.decline-order').on('click', function () {
    var confirm = confirmMessage('{{trans('messages.decline')}}','{{trans('messages.decline_order_confirm')}}','{{trans('messages.yes')}}','{{trans('messages.no')}}',$(this));
});
$('.cancel-order').on('click', function () {
    var confirm = confirmMessage('{{trans('messages.cancel')}}','{{trans('messages.cancel_order_confirm')}}','{{trans('messages.yes')}}','{{trans('messages.no')}}',$(this));
});
</script>
<script src="{{asset('assets/js/alert.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
@endsection
