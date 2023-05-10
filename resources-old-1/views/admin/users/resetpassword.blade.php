
@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Reset Password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->

                <ul>
                  @foreach ($errors->all() as $error)
                  <button type="button" class="btn btn-warning toastsDefaultWarning">
                    {{ $error }}
                  </button>
                  <br><br>
                  @endforeach
                </ul>
           
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Change Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('passwordReset', [encrypt($user->id)]) }}" method="post">
                  @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="password">New Password</label>                                           
                      <input type="password" class="form-control " id="password" placeholder="New Password" name="password" required>        
                    </div>
                    
                      <div class="form-group">
                        <label for="cpassword">Confirm Password</label>                                           
                        <input type="text" class="form-control " id="cpassword" placeholder="Confirm Password" name="ConfirmPassword" required>        
                      </div>
                  
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <div class="col-4">
                      <input type="submit" class="btn btn-primary btn-block" value="Save">
                    </div>
                  </div>
                </form>
              </div>
              <!-- general form elements -->
            </div> 
            <!--/.col (left) -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection