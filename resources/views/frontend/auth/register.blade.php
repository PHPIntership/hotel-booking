@extends('layouts.frontend')

@section('content')
<div class="row registerform" style="margin-bottom:30px">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group formtitle">
            <span class="label label-register">Create an account</span>
        </div>
        @include('layouts.frontend.partials.flash')
        {!! Former::open_for_files(route('user.register'))
            ->method('POST')
        !!}
        <img src="{{ asset('frontend/images/user.png') }}" class="img-responsive userpic" alt="Image">
        {!! Former::file('image')
            ->label(trans('messages.image'))
            ->accept('image')
        !!}

        {!! Former::text('username')
            ->label(trans('messages.username'))
        !!}
        {!! Former::password('password')
            ->label(trans('messages.password'))
        !!}

        {!! Former::password('retype_password')
            ->label(trans('messages.retype_password'))
        !!}
        {!! Former::text('email')
            ->label(trans('messages.email'))
        !!}
        {!! Former::text('name')
            ->label(trans('messages.name'))
        !!}
        {!! Former::text('address')
            ->label(trans('messages.address'))
        !!}
        {!! Former::text('phone')
            ->label(trans('messages.phone'))
        !!}
        <div style="text-align:center">
        {!! Former::submit(trans('messages.register'))
            ->class('btn btn-warning')
         !!}
        </div>
        {!! Former::close() !!}
    </div>
</div>
<script type="text/javascript">
/**
 * Check the file is an image before display preview
 */
$(document).ready(function(){
    window.location.hash = '#content';
});
$("#image").change(function () {
       var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
       if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
           alert("Only formats are allowed : "+fileExtension.join(', '));
       } else {
           readURL(this);
       }
   });
/**
 * Preview the image
 */
function readURL(input) {
    if (input.files && input.files[0] ) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.userpic')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
