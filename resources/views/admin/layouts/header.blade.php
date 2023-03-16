{{-- user details --}}
<?php 
if(Session::has('ADMIN_USER')){
  $user = session()->get('ADMIN_USER');
}

// echo "<pre>";
// dd($user);
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">New (total count) Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> New (Count) messages
            <span class="float-right text-muted text-sm">eg 3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> New added users
            <span class="float-right text-muted text-sm">eg 2hrs</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> Dynamic New content
            <span class="float-right text-muted text-sm">eg. 2days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      {{-- Expand full screen Button  --}}
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      {{-- Admin Account section --}}
      <li class="nav-item">
        <a class="nav-link d-flex" data-toggle="dropdown" href="#">
          @if(Session::has('ADMIN_USER'))
          <img src="{{ asset('dist/img/'.$user[4]) }}" class="img-circle elevation-2" alt="User Image" style="height: 2rem !important; width:2.1rem !important">
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 145px;">
          {{-- <span class="dropdown-header"> --}}
            @if(Session::has('ADMIN_USER'))
                <a href="#" class="dropdown-item" > <?php echo $user[1]; ?> </a>
              
            @endif          
          {{-- </span> --}}
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            Account
          </a>
          <div class="dropdown-divider"></div>
          <a href="/admin/logout" class="dropdown-item">
            <i class='fas fa-sign-out-alt'></i>
            Logout
            {{-- <span class="float-right text-muted text-sm"></span> --}}
          </a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->