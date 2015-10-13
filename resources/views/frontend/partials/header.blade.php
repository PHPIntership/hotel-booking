<div class="container-fluid" id="top">
    <div class="container">

        <div class="row" >
            <div class="col-md-6" id="loginbar">
                <span class="label label-warning">
                    <a href="#loginmodal" data-toggle="modal">Log in |</a>
                    <a href="#">Register</a>
                </span>
                <div class="modal fade" id="loginmodal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Log in</h4>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST" role="form">


                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" class="form-control input-md" id="" placeholder="Your username for log in" name="username">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" class="form-control input-md" id="" placeholder="Your password" name="password">
                                    </div>



                                    <button type="submit" class="btn btn-danger btn-block submitlogin">Submit</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 logout">
                <div id="loginbar-r">
                    <span class="label label-info">Hello <a href="#">Users |</a><a href="#"> Log out</a></span>

                </div>

            </div>
        </div>
    </div>

</div>
<div class="container-fluid" id="aftertop">
    <div class="container" >
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
