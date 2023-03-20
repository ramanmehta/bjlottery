@extends('admin.layouts.app')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Role Update</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Edit Role</li>
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
            <div class="col-md-6">
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
                  <h3 class="card-title">Update Role</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('update.role',[encrypt($role->id) ]) }}" method="post">              
                  @csrf
                  
                  {{-- <input type="hidden" name="id" value="{{encrypt($role->id)}}"> --}}
                  <div class="card-body">
                    <div class="form-group">
                      <label for="roles">Role</label>
                      <input type="text" class="form-control" id="roles" placeholder="Enter role" name="role_title" value="{{$role->role_title}}" required>
                    </div>
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>status</label>
                        <select class="form-control" name="status" required>
                          @if($role->id) 
                          <option value="{{$role->status}}" selected>
                            @if ($role->status == 1)
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