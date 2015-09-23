<form action="{{ route('admin.login') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group has-feedback">
      <input type="username" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username"/>
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" name="password" placeholder="Password"/>
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <div class="col-xs-8">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="remember"> Remember Me
          </label>
        </div>
      </div><!-- /.col -->
      <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
      </div><!-- /.col -->
    </div>
</form>
