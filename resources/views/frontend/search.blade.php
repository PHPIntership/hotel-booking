@extends('layouts.frontend')

@section('content')
<div id="search">
    <div class="mysearch">
        <div class="container-fluid searchform">
            <div class="row">
                {!! Former::vertical_open(route('user.searchresult'))->method('get')->id('searchform') !!}
                    {!! csrf_field() !!}
                    {!! Former::hidden('page')->value(0)->id('page') !!}
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
        @if(isset($paginateResult))
        @if(count($paginateResult) != 0)
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
                    <tbody>

                        @foreach($paginateResult as $key => $result)
                            @if($result->avaiable_quantity > 0)
                            @include('layouts.frontend.partials.search_result')
                            @endif
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="divpage">
                    <ul class="pagination pagination-sm">
                        @for($i = 0; $i < $totalPages; $i++)
    				      <li id="{{'li'.$i}}"><a value="{{$i}}" class="pagination_item">{{$i+1}}</a></li>
    				    @endfor
    				</ul>
                </div>

            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3" style="margin-top:30px">
                <div class="alert alert-info" role="alert"><strong>Sorry! </strong>None of result was found</div>
            </div>
        </div>

        @endif
        @endif
    </div>

</div>
@endsection

@section('js')
<script>
$('.pagination_item').on('click', function() {
    $('#page').val($(this).attr('value'));
    $('#submit').click();
});
    $(document).ready(function () {
        window.location.hash = '#content';
        var page = $('#page').val();
        $("li[id=li"+page+"]").addClass('active');
    });
</script>
@endsection
