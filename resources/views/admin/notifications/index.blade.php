
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
              
              <div class="row mb-2">
                <div class="col-sm-6">
                  {{-- <h1>Users</h1> --}}
                </div>
                <div class="col-sm-6">
                  <form action="" method="get">
                  <div class="input-group mb-3 ">
                    
                    <input type="search" class="form-control" placeholder="Search here" aria-label="search notification" aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}" id="search">
                    <input class="btn btn-outline-secondary" type="submit" value="Search">
                    
                  </div>
                </form>
                </div>
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
                    <td>{{$notifications->id}}</td>
                    <td>{{$notifications->user_id}}</td>
                    <td>{{$notifications->title}}</td>
                    <td>{{$notifications->description}}</td>
                    <td>{{$notifications->sent_at}}</td>
                    <td>
                      @if ($notifications->status==1)
                      <a onclick="return confirm('Are you sure deactivate notification : {{$notifications->title}}?')" href="{{route('notificationStatus',[encrypt($notifications->id)])}}"><input type="button" class="btn btn-success" value="Active"></a>
                      @else
                      <a onclick="return confirm('Are you sure activate notification : {{$notifications->title}}?')"  href="{{route('notificationStatus',[encrypt($notifications->id)])}}"><input type="button" class="btn btn-warning" value="Inactive"></a>
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
              <div class="row">
                  <div class="col-md-10"></div>
                  <div class="col-md-2">
                      <p class="text-sm text-gray-700 leading-5">
                        {!! __('Showing') !!}
                        <span class="font-medium">{{ $notification->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $notification->lastItem() }}</span>
                        {!! __('of') !!}
                        <span class="font-medium">{{ $notification->total() }}</span>
                        {!! __('results') !!}
                      </p>
                      @if ($notification->hasPages())
                          <ul class="pagination pagination">
                              {{-- Previous Page Link --}}
                              @if ($notification->onFirstPage())
                                  <li class="disabled page-item"><a href="{{$notification->currentPage()}}" class="page-link"><span>«</span></a></li>
                              @else
                                  <li class="page-item"><a class="page-link" href="{{ $notification->previousPageUrl() }}" rel="prev">«</a></li>
                              @endif
                      
                              @if($notification->currentPage() > 3)
                                  <li class="page-item"><a class="page-link" href="{{ $notification->url(1) }}">1</a></li>
                              @endif
                              @if($notification->currentPage() > 4)
                                  <li class="page-item"><span>...</span></li>
                              @endif
                              @foreach(range(1, $notification->lastPage()) as $i)
                                  @if($i >= $notification->currentPage() - 2 && $i <= $notification->currentPage() + 2)
                                      @if ($i == $notification->currentPage())
                                          <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                      @else
                                          <li class="page-item"><a class="page-link" href="{{ $notification->url($i) }}">{{ $i }}</a></li>
                                      @endif
                                  @endif
                              @endforeach
                              @if($notification->currentPage() < $notification->lastPage() - 3)
                                  <li class="page-item"><span class="page-link">...</span></li>
                              @endif
                              @if($notification->currentPage() < $notification->lastPage() - 2)
                                  <li class="page-item"><a class="page-link" href="{{ $notification->url($notification->lastPage()) }}">{{ $notification->lastPage() }}</a></li>
                              @endif
                      
                              {{-- Next Page Link --}}
                              @if ($notification->hasMorePages())
                                  <li class="page-item"><a class="page-link" href="{{ $notification->nextPageUrl() }}" rel="next">»</a></li>
                              @else
                                  <li class="page-item disabled"><a href="{{$notifications->lastPage()}}" class="page-link"><span>»</span></a></li>
                              @endif
                          </ul>
                      @endif      
                  </div>
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
