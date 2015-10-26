@extends('layouts.hotel')

@section('title')
{{ trans('messages.check_in') }}
@endsection
@section('css')
<style media="screen">
.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
    background: none;
    color: #eeeeee;
    cursor: no-drop;
}
.btn-check-out{
    margin-left: 10px;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('messages.check_out') }}</h3>
            </div><!-- /.box-header -->
                <!-- form start -->
            <div class="box-body">
                <div class="col-md-12 form-check-in">
                    @include('layouts.hotel.partials.flash')
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th style='width: 200px'>
                                    {{ trans('messages.room_name') }}
                                </th>
                                <th>
                                    {{ trans('messages.coming_date') }}
                                </th>
                                <th>
                                    {{ trans('messages.leave_date') }}
                                </th>
                                <th  style='width:150px'>
                                    {{ trans('messages.price') }}
                                </th>
                                <th>
                                    {{ trans('messages.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- */$toltal = 0;/* --}}
                            @foreach($checkIns as $key => $checkIn)

                            <tr>
                                <td>
                                    {{++$key}}
                                </td>
                                <td>

                                        @if(isset($rooms->keys()[$key-1]))
                                            {!!Former::select('rooms[]','')
                                            ->options($rooms, empty($checkIn->room_id) ?
                                            $rooms->keys()[$key-1] : $checkIn->room_id)
                                            ->class('form-control room-id')!!}
                                        @else
                                            het phong
                                        @endif

                                </td>
                                <td>
                                    {!! Former::text("coming_dates[$checkIn->id]", '')
                                        ->class('form-control input-date coming-date')
                                        ->value($checkIn->coming_date_format)
                                    !!}
                                </td>
                                <td>
                                    {!! Former::text("leave_dates[$checkIn->id]", '')
                                    ->class('form-control input-date leave-date')
                                    ->value(empty($checkIn->leave_date) ? '' : $checkIn->leave_date_format) !!}
                                </td>
                                <td>
                                    {!! Former::number("prices[$checkIn->id]", '')
                                    ->value(empty($checkIn->leave_date) ? '' : $checkIn->pay_price)->class('price form-control') !!}
                                    {{-- */ $toltal += $checkIn->pay_price; /* --}}
                                </td>
                                <td>
                                    @if (empty($checkIn->leave_date))
                                        <input type="button" data-check="{{!empty($checkIn->room_id)}}" name="btn-check-in" class='btn btn-check-in btn-primary' value="{{trans('messages.check_in')}}" data-url="{{route('hotel.checkin', $checkIn->id)}}">
                                    @endif
                                    @if (!empty($checkIn->room_id))
                                        <input type="button" data-check="{{!empty($checkIn->price)}}" name="btn-check-out" class='btn btn-check-out btn-warning' value="{{trans('messages.check_out')}}"  data-url="{{route('hotel.checkin', $checkIn->id)}}">
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              <td colspan='3'>Price Order: <span class='toltal-order'>{{$order->price}}</span></td>
                              <td colspan='3' class='text-right'>Price Check In: <span class='toltal'>{{$toltal}}</span></td>
                            </tr>
                          </tfoot>
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('frontend/js/bootstrap-datepicker.js') }}"></script>
<script>
var selectskill;
getOptionSelect();
disOptionSelect();
function getOptionSelect()
	{
		selectskill=[];
		$('select').children(':selected').each(function() {
			selectskill.push(parseInt($(this).parents("tr").find('select').val()));
	    });
	}
	function disOptionSelect()
	{
		$('select').children(':not(:selected)').each(function() {
		if($.inArray(parseInt($(this).val()),selectskill)>-1)
            $(this).attr('disabled', true);
        else
        	$(this).removeAttr('disabled');
        });
	}
    $('select').on('change' ,function(){
		getOptionSelect();
		disOptionSelect();
	});
    var coming_date =new Date( '{{$order->coming_date}}'.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3") );
    var leave_date =new Date( '{{$order->leave_date}}'.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3") );
    var checkin = $('.coming-date').datepicker({
        format: 'yyyy/mm/dd',
        onRender: function(date) {
            return date.valueOf() < coming_date || date.valueOf() > leave_date ? 'disabled' : '';
      }
    }).data('datepicker');
    var checkout = $('.leave-date').datepicker({
        format: 'yyyy/mm/dd',
        onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ||
            date.valueOf() < coming_date ||
            date.valueOf() > leave_date ? 'disabled' : '';
      }
    }).data('datepicker');

    $('.btn-check-in').on('click', function() {
        var thisBtn = $(this);
        if (thisBtn.attr('data-check')=='1') {
            if(!confirm("{{trans('messages.edit_check_in_question')}}")) {
                return;
            }
        }
        var parent = thisBtn.parents('tr');
        var roomId = parent.children().find('.room-id').val();
        var comingDate = parent.children().find('.coming-date').val();
        var data ={
            _token :'{{csrf_token()}}',
            _method : 'PUT',
            room_id : roomId,
            type : 'check_in',
            coming_date : comingDate
        };
        $.ajax({
            url: $(this).attr('data-url'),
            dataType: 'json',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8"
        }).done(function(response) {
            if(response['error']=='0') {
                if (!thisBtn.attr('data-check')=='1') {
                    thisBtn.attr('data-check','1');
                    var checkOut=$("<input>").attr({"type": "button","data-url":response['url']})
                        .addClass('btn btn-check-out btn-warning')
                        .val("{{trans('messages.check_out')}}");
                    checkOut.insertAfter(thisBtn);
                }
            }
            showMessages(response['messages'], response['error']);
        });
    })

    $(document).on('click', '.btn-check-out', function() {
        var thisBtn = $(this);
        var parent = thisBtn.parents('tr');
        var price = parent.children().find('.price').val();
        if (thisBtn.attr('data-check')=='1') {
            if(confirm("{{trans('messages.edit_check_out_price_question')}}")) {
                price = "";
            }
        }
        var roomId = parent.children().find('.room-id').val();
        var leaveDate = parent.children().find('.leave-date').val();

        if(leaveDate=="") {
            if(confirm("{{trans('messages.no_select_leave_date')}}")) {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                if(dd<10) {
                    dd='0'+dd
                }
                if(mm<10) {
                    mm='0'+mm
                }
                today = yyyy+'/'+mm+'/'+dd;
                leaveDate = today;
                parent.children().find('.leave-date').val(today);
            } else {
                return;
            }
        }
        var data ={
            _token :'{{csrf_token()}}',
            _method : 'PUT',
            room_id : roomId,
            price : price,
            type : 'check_out',
            leave_date : leaveDate
        };
        $.ajax({
            url: $(this).attr('data-url'),
            dataType: 'json',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8"
        }).done(function(response) {
            if(response['error']=='0') {
                thisBtn.attr('data-check', 1);
                parent.children().find('.price').val(response['data']['price']);
                parent.children().find('.coming_date').val(response['data']['coming_date']);
                var toltal = 0;
                $('.price').each(function (key, data){
                    toltal+=$(this).val()*100;
                });
                $('.toltal').html(toltal/100);
                parent.children().find('.btn-check-in').remove();
            }
            showMessages(response['messages'], response['error']);
        });
    })
    function showMessages(messages, type)
    {
        if (typeof messages != 'string') {
            var rsMessages='';
            $.each(messages, function (index, value) {
                rsMessages = value+"<br>";
            })
            messages = rsMessages
        }
        $('.alert').remove();
        type = type==1? 'alert-danger' : 'alert-success';
        $div2=$('<div class="alert " role="alert">').addClass(type);
        $div2.append($('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>'));
        $div2.append($("<strong></strong>").html("Error!"));
        $div2.append($("<span></span>").html("&nbsp;"+messages));

        $(".form-check-in").prepend($div2);
        $(".alert").delay(5000).hide(1000);
            setTimeout(function() {
            $('.alert').remove();
        }, 6500);
    }
</script>
@endsection
