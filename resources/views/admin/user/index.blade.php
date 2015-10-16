@extends('layouts.admin')
@section('title')
    {{trans('messages.user')}}
@endsection
@section('content')
<div class="row " id="example2">
<div class="col-md-12">
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{!! trans('messages.user') !!}</h3>
    </div>
    <div class="box-body">
        @include('layouts.admin.partials.flash')
        <table class="table table-bordered table-striped" id="example1_wrapper">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{!! trans('messages.name') !!}</th>
                        <th>{!! trans('messages.username') !!}</th>
                        <th>{!! trans('messages.email') !!}</th>
                        <th>{!! trans('messages.phone') !!}</th>
                        <th>{!! trans('messages.address') !!}</th>
                        <th>{!! trans('messages.image') !!}</th>
                        <th style="width:200px">{!! trans('messages.action') !!}</th>
                </thead>
                <tbody>
                @foreach ($users  as $key => $user)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td><img src="{{$user->image_link}}" alt="User image" style="width:200px;height:auto" class="img-thumbnail user-image"></td>
                    <td>
                        <a href="{!! route('admin.user.edit',$user->id) !!}" class="btn btn-info">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            {!! trans('messages.edit') !!}
                        </a>
                        {!! Former::open()->route('admin.user.destroy',$user->id)->method('Delete')->style('display: inline') !!}
                        <button onclick="return message('{!! trans('messages.delete_confirm') !!}')" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            {!! trans('messages.delete') !!}
                        </button>
                        {!! Former::close() !!}
                    </td>
                </tr>
                @endforeach
              </tbody>
          </table>
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4" > {!! $users->render() !!} </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/message.js')}}"></script>
@endsection
