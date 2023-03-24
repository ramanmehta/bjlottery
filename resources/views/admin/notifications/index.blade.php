{{-- @php
    dd($user);
@endphp --}}

@extends('admin.layouts.app')

@section('content')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notifications</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Notifications</li>
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
              <div class="card-header">
                <h3 class="card-title">User Notifications</h3>
                <a href="{{route('createNotifications')}}"><button type="button" class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i>New Notifications</button></a>
              </div>
              
              
              <!-- /.card-header -->
              <div class="card-body">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible col-lg-6" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong></strong> {{ $message }}
                </div>
              @endif
              @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible col-lg-6" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong></strong> {{ $message }}
                </div>
              @endif
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>User Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Sent At</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($notification as $notifications)
                  <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{$notifications->user_id}}</td>
                    <td>{{$notifications->title}}</td>
                    <td>{{$notifications->description}}</td>
                    <td>{{$notifications->sent_at}}</td>
                    <td>
                      @if ($notifications->status==1)
                      <input type="button" class="btn btn-success" value="Active">
                      @else
                      <input type="button" class="btn btn-warning" value="Inactive">
                      @endif  
                     </td>
                    <td>
                      <a href="{{route('editNotifications',[encrypt($notifications->id)])}}"><button type="button" class="btn btn-success" ><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('Are you sure remove lucky draw : {{$notifications->title}}?')" href="{{route('removeNotifications',[encrypt($notifications->id)])}}"><button type="button" class="btn btn-danger" ><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a> 

                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

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
