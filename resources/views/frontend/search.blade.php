@extends('layouts.frontend')
@section('content')

<div id="search">
    <div class="mysearch">
        <div class="container-fluid searchform">
            <div class="row">
                {!! Former::vertical_open(route('user.searchresult'))->method('get')->id('searchform') !!}
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-4 col-md-offset-2">
                            {!! Former::select('city')
                                ->label('City')
                                ->options($cities)
                            !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Former::select('roomtype')
                            ->label('Room type')
                            ->options($roomTypes)
                            !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3 col-md-offset-3">
                            {!! Former::text('coming_date')
                                ->value(date('Y/m/d'))
                            !!}
                            <script>
                                $(function() {
                                    $("#coming_date").datepicker({
                                        format: 'yyyy/mm/dd',
                                        startDate: '-3d'
                                    });
                                });
                            </script>
                        </div>
                        <div class="form-group col-md-3">
                            {!! Former::text('leave_date')
                                ->value(date('Y/m/d'))
                            !!}
                            <script>
                                $(function() {
                                    $("#leave_date").datepicker({
                                        format: 'yyyy/mm/dd',
                                        startDate: '-3d'
                                    }).on('changeDate', function(e) {
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="row">
                            <button id="submit" type="submit" name="submit" class="btn btn-primary col-md-2 col-md-offset-5 btn-lg">{{trans('messages.search')}} <span class='glyphicon glyphicon-search'></span></button>
                    </div>

                {!! Former::close() !!}
            </div>

        </div>

    </div>

    <div class="container-fluid result">
        @if(isset($results))
        @if($results->count()>0)
        <div class="myresult row">
            <h2>
                <span class="label label-danger">{{trans('messages.result_search')}}</span>
            </h2>
            <div class="row table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{trans('messages.hotel')}}</th>
                            <th>{{trans('messages.image')}}</th>
                            <th>{{trans('messages.description')}}</th>
                            <th>{{trans('messages.action')}}</th>
                        </tr>
                    </thead>
                    <tbody id="search_body">
                            @include('layouts.frontend.partials.search_result')
                    </tbody>
                </table>
                <div class="col-md-2 col-md-offset-5" style="margin-bottom:30px">
                    <button id="loadmore" type="button" name="button" class="btn btn-success btn-block btn-lg">{{trans('messages.load_more')}}</button>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-top:30px">
                <div class="alert alert-info" role="alert"><strong>{{trans('messages.sorry')}}! </strong>{{trans('messages.empty_result')}}</div>
            </div>
        </div>
        @endif


        @endif
    </div>

</div>
@endsection

@section('js')
<script type="text/javascript">
var offset = {{Session::get('number_of_result')}}
$('#loadmore').on('click', function (){
    $.ajax({
        type: 'get',
        url: '{{route('user.moresearch')}}',
        data: {
            city: $('#city').val(),
            roomtype: $('#roomtype').val(),
            coming_date: $('#coming_date').val(),
            leave_date: $('#leave_date').val(),
            offset: offset
        },
        success: function(response) {
            // alert(response);
            if (response != ''){
                $('#search_body').append(response);
                offset+=offset;
            } else {
                $('#loadmore').attr('style', 'display:none');
            }
        }
    });
});

</script>
@endsection
