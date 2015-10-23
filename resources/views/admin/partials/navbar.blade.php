<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <span class="hidden-xs">{{ Auth::admin()->get()->username }}</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-sm-header">
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{ route('admin.profile.edit') }}" class="btn btn-default btn-flat">{{ trans('messages.profile') }}</a>
            </div>
            <div class="pull-right">
              <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">{{ trans('messages.log_out') }}</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
    </ul>
  </div>
</nav>
