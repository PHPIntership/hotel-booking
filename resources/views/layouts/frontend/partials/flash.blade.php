@if (Session::has('flash_success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Success! </strong>{{ Session::get('flash_success') }}
    </div>
@elseif (Session::has('flash_error'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Error! </strong>{{ Session::get('flash_error') }}
    </div>
@elseif (Session::has('flash_info'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Info! </strong>{{ Session::get('flash_info') }}
    </div>
@endif
