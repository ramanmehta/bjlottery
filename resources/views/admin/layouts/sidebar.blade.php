<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <?php $currentRoute = Route::currentRouteName();?>
  <!-- Brand Logo -->
  <a href="{{ route('admin.dashboard') }}" class="brand-link">
    <img src="{{ asset('dist/img/favicon.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8;width: 40px; height: 40px">
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
          <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ in_array($currentRoute,['admin.dashboard']) ? 'active' : '' }}">
            Home
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="{{ route('admin.users') }}"
            class="nav-link {{ in_array($currentRoute,['admin.users','edituser','update.User','removeUser','userStatus','userAppoint','updateAppoint','editWallet','updateWallet','cPassword','passwordReset']) ? 'active' : '' }}">
            Users
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="{{route('luckyDraw')}}"
            class="nav-link {{ in_array($currentRoute,['add.price','add.price.form','luckyDraw','createLuckyDraw','user.LuckyDraw','editLuckyDraw','update.LuckyDraw','removeLuckyDraw','luckyDrawsStatus']) ? 'active' : '' }}">
            Lottery List
          </a>
        </li>

        <li class="nav-item menu-open">
          <a href="{{route('RewardType')}}"
            class="nav-link {{ in_array($currentRoute,['RewardType','RewardType','createRewardType','create.RewardType','editRewardType','update.RewardType','removeRewardType','rewardStatus']) ? 'active' : '' }}">
            Daily Rewards
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="{{route('mission')}}"
            class="nav-link {{ in_array($currentRoute,['mission','createMission','user.Mission','editMission','update.Mission','removeMission','missionStatus']) ? 'active' : '' }}">
            Missions
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="{{route('mission-submissions.index')}}"
            class="nav-link {{ in_array($currentRoute,['mission-submissions.index','missionsubmissions.show']) ? 'active' : '' }}">
            All Mission Submission
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="{{route('winner.user.claim')}}"
            class="nav-link {{ in_array($currentRoute,['winner.user.claim']) ? 'active' : '' }}">
            Prize Claim List
          </a>
        </li>
        <li class="nav-item menu-open">
          <a href="{{route('withdraw')}}" class="nav-link {{ in_array($currentRoute,['withdraw']) ? 'active' : '' }}">
            Withdraw
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>