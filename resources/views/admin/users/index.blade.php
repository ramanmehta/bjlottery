@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
            <li class="breadcrumb-item active">User</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">

            {{-- float-sm-right --}}


            <!-- /.card-header -->
            <div class="card-body">
              @if ($message = Session::get('success'))
              <div class="alert alert-success alert-dismissible col-lg-12" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                <strong></strong> {{ $message }}
              </div>
              @endif
              @if ($message = Session::get('error'))
              <div class="alert alert-danger alert-dismissible col-lg-12" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                  <i class="fa fa-times"></i>
                </button>
                <strong></strong> {{ $message }}
              </div>
              @endif
              <div class="row mb-2">
                <div class="col-sm-6">
                  {{-- <h1>Users</h1> --}}
                </div>
                <div class="col-sm-6">
                  <form action="" method="get">
                    <div class="input-group mb-3 ">

                      <input type="search" class="form-control" placeholder="Search here" aria-label="search user"
                        aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}"
                        id="search">
                      &nbsp;
                      &nbsp;
                      <input class="btn btn-outline-secondary" type="submit" value="Search">

                    </div>
                  </form>
                </div>
              </div>
              <!--example1-->
              <table id="" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <!--<th>Id</th>-->
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Referal Code</th>
                    <th>User Image</th>
                    <th>AP Points</th>
                    <th>Wallet</th>
                    <th>Reset Password</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($user as $users)
                  <tr>
                    <td>{{$users->name}}</td>
                    <td>{{$users->email}}</td>
                    <td>{{$users->phone}}</td>
                    <td>{{$users->referal_code}}</td>
                    <td><img src="{{$users->logo}}" style="height: 50px;" alt="User Image"></td>
                    <td>
                      {{$users->total_point_available}}
                      <a style="margin:10px;" href="{{route('userAppoint',[encrypt($users->id)])}}"><i
                          class='fas fa-coins'></i>&nbsp;</a>
                    </td>
                    <td>
                      {{$users->total_cash_available}}
                      <a style="margin:10px;" href="{{route('editWallet',[encrypt($users->id)])}}"><i
                          class='fas fa-wallet'></i>&nbsp;</a>
                    </td>
                    <td>
                      <a style="margin:10px;" href="{{route('cPassword',[encrypt($users->id)])}}"><i
                          class='fas fa-user-lock'></i>&nbsp;</a>
                    </td>
                    <td>
                      @if ($users->status==1)
                      <a onclick="return confirm('Are you sure deactivate user : {{$users->name}}?')"
                        href="{{route('userStatus',[encrypt($users->id)])}}"><input type="button"
                          class="btn btn-success btn-sm" value="Activated"></a>
                      @else
                      <a onclick="return confirm('Are you sure activate user : {{$users->name}}?')"
                        href="{{route('userStatus',[encrypt($users->id)])}}"><input type="button"
                          class="btn btn-warning btn-sm" value="Inactive"></a>
                      @endif
                    </td>
                    <td>
                      <a href="{{route('edituser',[encrypt($users->id)])}}"><button type="button"
                          class="btn btn-success btn-sm"><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('Are you sure remove user : {{$users->name}}?')"
                        href="{{route('removeUser',[encrypt($users->id)])}}"><button type="button"
                          class="btn btn-danger btn-sm"><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <br>
              {!! $user->links() !!}
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
{{-- <script src="../../plugins/jquery/jquery.min.js"></script> --}}
<!-- Bootstrap 4 -->
{{-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<!-- DataTables  & Plugins -->
<!-- DataTables  & Plugins -->

@endsection