@foreach($results as $result)
<tr>
    <td>
        <h3>{{$result->hotel->name.' ('.$result->hotel->quality}} <span class="glyphicon glyphicon-star" aria-hidden="true">)</span></h3>
        <p class="label label-warning">{{$result->price.' $'}}</p></br>
        <p>Address: {{$result->hotel->address}}</p>
        <p>Phone: {{$result->hotel->phone}}</p>
    </td>
    <td>
        <!-- <img src="{{asset('uploads/hotel/sheraton_chicago_o_hare_airport_hotel.jpg')}}"> -->
        <img src="{{$result->hotel->image_link}}">
    </td>
    <td>
        <h4>{{$result->name}}</h4>
        <p>{{$result->description}}</p>
        <p>Avaiable: <span class="label label-danger" style="font-size:15px;">{{ $result->quantity - $result->ordered }}</span></p>
    </td>
    <td>
        <a href="#" class="btn btn-success btn-lg">{{trans('messages.book')}}</a>
    </td>
</tr>
@endforeach
