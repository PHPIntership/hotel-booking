<div class="container-fluid" id="top">
    <div class="container">

        <div class="row">
            <div class="col-md-6" id="loginbar">
                <span class="label label-warning">
                    <a id="login_button" href="#loginmodal" data-toggle="modal">Log in |</a>
                    <a href="#">Register</a>
                </span>
                <div class="modal fade" id="loginmodal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Log in</h4>
                            </div>
                            <div class="modal-body">
                                <div id="error"></div>
                                {!! Former::vertical_open()
                                    ->rules([ 'username' => 'required|max:255', 'password' => 'min:6|max:255|required' ])
                                !!}
                                {!! Former::text('username')
                                    ->label('Username:')
                                !!}
                                {!! Former::password('password')
                                    ->label('password')
                                !!}
                                <button id="submit_login" type="button" class="btn btn-danger btn-block submitlogin">Sign In</button>
                                {!! Former::close() !!}

                                <!-- Ajax login request -->
                                <script type="text/javascript">
                                    $('#submit_login').on('click', function() {
                                        var pathname = window.location.href;
                                        $.ajax({
                                            url: "{{ route('user.login') }}",
                                            type: 'post',
                                            data: {
                                                username: $('#username').val(),
                                                password: $('#password').val(),
                                                _token: $('input[name=_token]').val()
                                            },
                                            success: function(response) {
                                                // if(typeof response =='object')
                                                // {
                                                //     window.location.href = response['url'];
                                                // } else {
                                                //     $('#error').html(response);
                                                // }
                                                if (response['status'] === 'success') {
                                                    window.location.href = response['url'];
                                                } else if (response['status'] === 'failed') {
                                                    var alertContent =
                                                    '<div class="alert alert-danger alert-dismissable">' +
                                                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                                    '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
                                                    response['message'] +
                                                    '</div>';
                                                    $('#error').html(alertContent);
                                                } else if (response['status'] === 'logged') {
                                                    var alertContent =
                                                    '<div class="alert alert-info alert-dismissable">' +
                                                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                                    '<h4><i class="icon fa fa-ban"></i> Info!</h4>' +
                                                    response['message'] +
                                                    '</div>';
                                                    $('#error').html(alertContent);
                                                }
                                            },
                                            error: function(response) {
                                                $('#error').html('');
                                                var alertContent =
                                                    '<div class="alert alert-danger alert-dismissable">' +
                                                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                                    '<h4><i class="icon fa fa-ban"></i> Alert!</h4>' +
                                                    '<ul>';
                                                $.each(response['responseJSON'], function(key, item) {
                                                    alertContent += '<li>' + item + '</li>';
                                                });
                                                alertContent += '</div>';
                                                $('#error').append(alertContent);
                                            }
                                        });
                                    });
                                </script>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 logout">
                <div id="loginbar-r">
                    <span ip="logged_info" class="label label-info">Hello
                        @if(Auth::user()->check())
                        <a href="#">{{Auth::user()->get()->name}} |</a>
                        <a href="{{ route('user.logout') }}">Log out</a>
                        @endif
                    </span>

                </div>

            </div>
        </div>
    </div>

</div>
<div class="container-fluid" id="aftertop">
    <div class="container">
        <div class="row">
            <div class="col-md-3 logo">
                <img src="{{ asset('frontend/images/logo1.png') }}" class="img-responsive" alt="Image">
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
</div>
