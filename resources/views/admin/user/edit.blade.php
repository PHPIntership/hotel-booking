@extends('layouts.admin')

@section('content')
<section class="content">
<div class="row">
    <div class="col-md-12 center">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{trans('messages.edit_profile')}}</h3>
            </div>
            {!!Former::vertical_open(route('admin.profile.edit'))
                ->method('PUT')
                ->id('form-edit-profile')!!}
            <div class="box-body">
                @include('layouts.admin.partials.flash')
              <div class="form-group col-md-8 col-md-offset-2">
                {!!Former::password('old_password')
                          ->label(trans('messages.old_password'))
                          ->placeholder(trans('messages.old_password'))
                          ->class('form-control')!!}
                {!!Former::password('new_password')
                          ->label(trans('messages.new_password'))
                          ->placeholder(trans('messages.new_password'))
                          ->class('form-control')!!}
                {!!Former::password('confirm_new_password')
                          ->label(trans('messages.confirm_new_password'))
                          ->placeholder(trans('messages.confirm_new_password'))
                          ->class('form-control')!!}
                </div>
            </div><!-- /.box-footer -->
      <div class="box-body">
          <div class="form-group col-md-8 col-md-offset-2">
              <div class="text-center">
                <input type="submit" value="{{trans('messages.update')}}" class="btn-primary btn">
                <input type="reset" value="{{trans('messages.reset')}}" class="btn-primary btn">
              </div>
          </div>
      </div><!-- /.box-footer -->

  {!!Former::close()!!}
</div><!-- /.box-primary -->
</div>
</div>
</section>
@endsection
