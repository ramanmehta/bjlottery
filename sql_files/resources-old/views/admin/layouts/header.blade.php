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
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link d-flex" data-toggle="dropdown" href="#">
          @if(Session::has('ADMIN_USER'))
          <img src="{{ asset('dist/img/'.$user[4]) }}" class="img-circle elevation-2" alt="User Image" style="height: 2rem !important; width:2.1rem !important">
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 145px;">
          
            @if(Session::has('ADMIN_USER'))
                <a href="#" class="dropdown-item" > <?php echo $user[1]; ?> </a>
            @endif          
          <div class="dropdown-divider"></div>
          <a href="{{ route('admin.logout') }}" class="dropdown-item"><i class='fas fa-sign-out-alt'></i> Logout</a>
          
          <div class="dropdown-divider"></div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->