@extends('layouts.frontend')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">
<script src="{{ asset('assets/js/alert.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
@endsection
@section('content')
<div id="order-wrap" class="col-sm-12">
<div id="order-info" class="col-sm-5">
  <h1>{{$order->hotelRoomType->hotel->name}}</h1>
  <img class="img-thumbnail" src="{{$order->hotelRoomType->imageLink}}" />
  <h3>{{$order->hotelRoomType->name}}</h3>
  <label class="alert-info">
      {{trans('messages.available_rooms', ['available_quantity' => $order->availableRoomQuantity])}}
  </label>
  <p>{{$order->hotelRoomType->hotel->address}},
  {{$order->hotelRoomType->hotel->city->name}}</p>
  <p>{{trans('messages.price')}}: {{$order->hotelRoomType->price}}</p>
</div>
<div id="order-form" class="col-sm-7">
  <h1>{{trans('messages.order')}}</h1>
  {!! Former::horizontal_open()
      ->method('POST')
      ->action(route('order.store'))
  !!}
  @include('layouts.frontend.partials.flash')
  {!! Former::hidden('hotel_room_type_id')
      ->value($order->hotel_room_type_id)
  !!}
  {!! Former::date('coming_date')
      ->label( trans('messages.coming_date') )
      ->value(date('Y/m/d', strtotime($order->coming_date)))
  !!}
  {!! Former::date('leave_date')
      ->label( trans('messages.leave_date') )
      ->value(date('Y/m/d', strtotime($order->leave_date)))
  !!}
  {!! Former::text('quantity')
      ->label(trans('messages.quantity'))
      ->value($order->quantity)
  !!}
  {!! Former::textarea('comment')
      ->label( trans('messages.comment') )
      ->value($order->comment)
      ->style('resize: none')
  !!}
  {!! Former::text('price')
      ->label( trans('messages.price') )
      ->value($order->price)
      ->disabled('')
  !!}
  @if(Auth::user()->check())
      {!! Former::button(trans('messages.order_submit'))
          ->class('btn btn-info pull-right')
          ->id('submit-order')!!}
  @else
      {!! Former::label(trans('messages.order_login_request'))
          ->class('alert-danger pull-right')
           !!}
  @endif
  {!! Former::close() !!}
</div>
</div>
</div>
@endsection

@section('js')
<script>
    var orderPrice = function(){
        var comingDate = new Date($('#coming_date').val());
        var leaveDate = new Date($('#leave_date').val());
        var days = (new Date(leaveDate - comingDate))/1000/60/60/24;
        var quantity = $('#quantity').val();
        var price = {{$order->hotelRoomType->price}};
        $('#price').val(price*quantity*days);
    }
    $(document).ready(function(){
        orderPrice();
        $( "#coming_date" ).datepicker({
            format: 'yyyy/mm/dd',
            startDate: '-3d'
        });
        $( "#leave_date" ).datepicker({
            format: 'yyyy/mm/dd',
            startDate: '-3d'
        });
        $('#coming_date').on("change", orderPrice);
        $('#coming_date').on("changeDate", orderPrice);
        $('#leave_date').on("change", orderPrice);
        $('#leave_date').on("changeDate", orderPrice);
        $('#quantity').on("change", orderPrice);
        $('#submit-order').on("click", function(){
            confirmMessage(
                '{{trans('messages.order_confirm')}}',
                '{{trans('messages.order_comfirm_message')}}',
                '{{trans('messages.yes')}}',
                '{{trans('messages.no')}}',
                $(this));
        });
    });
</script>
@endsection
