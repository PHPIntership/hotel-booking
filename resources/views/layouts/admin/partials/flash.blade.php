@if (Session::has('flash_message'))
    <div class="alert alert-{{Session::get('flash_level')}}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong></strong>
        {{ Session::get('flash_message') }}
    </div>
@endif