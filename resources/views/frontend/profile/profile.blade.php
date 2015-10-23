@extends('layouts.frontend')
@section('title')
    {{trans('messages.profile')}}
@endsection
@section('content')
<div id="content" class="container">
    <div class="row">
    <div class="container-fluid" id="profilepage">
    <div class="row">
        <div class="col-md-12">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#profle" aria-controls="home" role="tab" data-toggle="tab">Profile</a>
                    </li>
                    <li role="presentation">
                        <a href="#orderhistory" aria-controls="tab" role="tab" data-toggle="tab">Order history</a>
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
                            @include('layouts.hotel.partials.flash')
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
                            {!! Former::submit('Update')->class('btn btn-info') !!}
                            {!! Former::close() !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane table-responsive" id="orderhistory">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order day</th>
                                    <th>Room type</th>
                                    <th>Coming day</th>
                                    <th>Leave day</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Comments</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>19/09/2015</td>
                                    <td>Good</td>
                                    <td>20/09/2015</td>
                                    <td>25/09/2015</td>
                                    <td>3</td>
                                    <td>2000$</td>
                                    <td>Accepted</td>
                                    <td>Welcome to our hotel! we have accepted your request</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>18/08/2015</td>
                                    <td>5 *</td>
                                    <td>13/08/2015</td>
                                    <td>20/09/2015</td>
                                    <td>2</td>
                                    <td>1500$</td>
                                    <td>Waiting for accept</td>
                                    <td>Please wait us to reply your request</td>
                                    <td><a href="#"><span class="label label-info">Cancel</span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
@endsection
