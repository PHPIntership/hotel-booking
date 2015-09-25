@extends('layouts.admin')

@section('content')
<section class="content">
<div class="row">
    <div class="col-md-12 center">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Edit Profile</h3>
            </div>
{!!Former::vertical_open(route('admin.edit.profile'))
          ->method('PUT')

          ->id('form-edit-profile')!!}
      <div class="box-body">
        <div class="form-group col-md-8 col-md-offset-2">
          {!!Former::password('old_password')
                    ->label('Old Password')
                    ->placeholder('Old Password')
                    ->class('form-control')!!}
          {!!Former::password('new_password')
                    ->label('New Password')
                    ->placeholder('New Password')
                    ->class('form-control')!!}
          {!!Former::password('confirm_new_password')
                    ->label('Confirm New Password')
                    ->placeholder('Confirm New Password')
                    ->class('form-control')!!}
          </div>
      </div><!-- /.box-footer -->
      <div class="box-body">
          <div class="form-group col-md-8 col-md-offset-2">
              <div class="text-center">
                <input type="submit" value="Accept" class="btn-primary btn">
                <input type="reset" value="Reset" class="btn-primary btn">
              </div>
          </div>
      </div><!-- /.box-footer -->

  {!!Former::close()!!}
</div><!-- /.box-primary -->
</div>
</div>
</section>
@endsection
