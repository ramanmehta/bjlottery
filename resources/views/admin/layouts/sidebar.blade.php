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
          <li class="nav-item menu-open">
            <a href="{{route('luckyDraw')}}" class="nav-link @if($currentRoute == 'luckyDraw') {{'active'}} @endif">
            Lottery List
            </a>
          </li>
         
          <li class="nav-item menu-open">
            <a href="{{route('RewardType')}}" class="nav-link @if($currentRoute == 'RewardType') {{'active'}} @endif">
            Reward Type
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{route('mission')}}" class="nav-link @if($currentRoute == 'mission') {{'active'}} @endif">
            Missions
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{route('mission-submissions.index')}}" class="nav-link @if($currentRoute == 'mission-submissions.index') {{'active'}} @endif">
            Missions Submission
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{route('winner.user.claim')}}" class="nav-link @if($currentRoute == 'winner.user.claim') {{'active'}} @endif">
            Luckey Winner Claimed
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{route('withdraw')}}" class="nav-link @if($currentRoute == 'withdraw') {{'active'}} @endif">
              Withdraw
            </a>
          </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>