@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Update</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Edit User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->

                <ul>
                  @foreach ($errors->all() as $error)
                  <button type="button" class="btn btn-warning toastsDefaultWarning">
                    {{ $error }}
                  </button>
                  @endforeach
                </ul>
           
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Update User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('update.User',[encrypt($user->id) ]) }}" method="post">              
                  @csrf
                  
                  {{-- <input type="hidden" name="id" value="{{encrypt($role->id)}}"> --}}
                  <div class="card-body">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{$user->name}}" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="usernsme"placeholder="Enter username" name="username" value="{{$user->username}}" required>
                      </div>
                    </div>
                  
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{$user->name}}" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="usernsme"placeholder="Enter username" name="username" value="{{$user->username}}" required>
                      </div>
                    </div>  
                      
                      <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>status</label>
                        <select class="form-control" name="status" required>
                          @if($user->id) 
                          <option value="{{$user->status}}" selected>
                            @if ($user->status == 1)
                                Active
                            @else
                              Inactive
                            @endif
                          </option>
                          @endif
                          <option disabled>Select Status</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <div class="col-4">
                      <input type="submit" class="btn btn-primary btn-block" value="Update">
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