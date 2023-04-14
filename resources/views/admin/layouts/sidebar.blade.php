 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
    <?php $currentRoute = Route::currentRouteName();?>
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <img src="{{ asset('dist/img/favicon.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 40px; height: 40px">
      <span class="brand-text font-weight-light">BJ Lottery</span>
    </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ route('admin.dashboard') }}" class="nav-link <?php if ($currentRoute == 'admin.dashboard') {echo 'active';}?>">
                Home
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{ route('admin.users') }}" class="nav-link <?php if ($currentRoute == 'admin.users') {echo 'active';}?>">
              Users
            </a>
          </li>
          {{-- <li class="nav-item menu-open">
            <a href="{{route('viewRoles')}}" class="nav-link @if($currentRoute == 'viewRoles') {{'active'}} @endif">
            Roles
            </a>
          </li> --}}
          <li class="nav-item menu-open">
            <a href="{{route('luckyDraw')}}" class="nav-link @if($currentRoute == 'luckyDraw') {{'active'}} @endif">
            Lottery List
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{route('mission')}}" class="nav-link @if($currentRoute == 'mission') {{'active'}} @endif">
            Missions(Levels)
            </a>
          </li>
          {{-- <li class="nav-item menu-open">
            <a href="{{route('DailyRewards')}}" class="nav-link @if($currentRoute == 'DailyRewards') {{'active'}} @endif">
            Daily Rewards
            </a>
          </li> --}}
          <li class="nav-item menu-open">
            <a href="{{route('RewardType')}}" class="nav-link @if($currentRoute == 'RewardType') {{'active'}} @endif">
            Reward Type
            </a>
          </li>
          {{-- <li class="nav-item menu-open">
            <a href="{{route('referalstatus')}}" class="nav-link @if($currentRoute == 'referalstatus') {{'active'}} @endif">
            Referals Stats
            </a>
          </li> --}}
          <li class="nav-item menu-open">
            <a href="{{route('settings')}}" class="nav-link @if($currentRoute == 'settings') {{'active'}} @endif">
            Settings
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{route('notifications')}}" class="nav-link @if($currentRoute == 'notifications') {{'active'}} @endif">
            Notifications
            </a>
          </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>