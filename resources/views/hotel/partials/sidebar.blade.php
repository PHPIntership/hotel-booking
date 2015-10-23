<section class="sidebar">
  <!-- search form -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
      <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
      </span>
    </div>
  </form>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header">{{trans('messages.menu')}}</li>
    <li class="active treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>{{ trans('messages.hotel') }}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('hotel.profile') }}"><i class="fa fa-circle-o"></i>{{ trans('messages.profile') }}</a></li>
        </ul>
        <a href="#">
            <i class="fa fa-th"></i> <span>{{ trans('messages.room') }}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('hotel.room.create') }}"><i class="fa fa-circle-o"></i>{{ trans('messages.create') }}</a></li>
            <li><a href="{{ route('hotel.room.index') }}"><i class="fa fa-circle-o"></i>{{ trans('messages.list') }}</a></li>
        </ul>
        <a href="#">
            <i class="fa fa-table"></i> <span>{{ trans('messages.hotel_room_type') }}</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('hotel.room-type.create') }}"><i class="fa fa-circle-o"></i>{{ trans('messages.create') }}</a></li>
            <li><a href="{{ route('hotel.room-type.index') }}"><i class="fa fa-circle-o"></i>{{ trans('messages.list') }}</a></li>
        </ul>
    </li>
  </ul>
</section>
