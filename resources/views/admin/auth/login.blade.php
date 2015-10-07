<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HotelBooking | Admin Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/AdminLTE/bootstrap/css/bootstrap.min.css')}}">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">{{trans('messages.admin_login')}}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{trans('messages.sign_start')}}</p>
            {!!Former::vertical_open(route('admin.login'))
            ->method('POST')
            ->id('form-edit-profile')!!}
            {!!Former::text('username','')
            ->placeholder(trans('messages.username'))
            ->class('form-control has-feedback')
            !!}
            {!!Former::password('password','')
            ->placeholder(trans('messages.password'))
            ->class('form-control')
            !!}
            <div class="row">
                <div class="col-xs-8">
                    {!!Former::checkbox('remember','')->text(trans('messages.remember'))!!}
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{trans('messages.sign_in')}}</button>
                </div>
            </div>

            {!!Former::close()!!}
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
