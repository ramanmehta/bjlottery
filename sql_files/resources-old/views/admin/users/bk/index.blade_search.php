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
              <div class="row mb-2">
                <div class="col-sm-6">
                  {{-- <h1>Users</h1> --}}
                </div>
                <div class="col-sm-6">
                  <form action="" method="get">
                  <div class="input-group mb-3 ">
                    
                    <input type="search" class="form-control" placeholder="Search here" aria-label="search user" aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}" id="search">
                    <input class="btn btn-outline-secondary" type="submit" value="Search">
                    {{-- <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button">Button</button>
                    </div> --}}
                  </div>
                </form>
                </div>
              </div>
              {{-- <form method="GET">

        <div class="input-group mb-3">

          <input 

            type="text" 

            name="search" 

            value="{{ request()->get('search') }}" 

            class="form-control" 

            placeholder="Search..." 

            aria-label="Search" 

            aria-describedby="button-addon2">

          <button class="btn btn-success" type="submit" id="button-addon2">Search</button>

        </div>

    </form> --}}
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
              <!--example1-->
                <table id="" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <!--<th>Id</th>-->
                    <th>User Name</th>
                    {{-- <th>Role</th> --}}
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Logo</th>
                    <th>AP Points</th>
                    <th>Wallet</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($user as $users)
                  <tr>
                    {{-- <td>{{$loop->index }}</td> --}}
                    {{-- <td>{{$users->id }}</td> --}}
                    <td>{{$users->username}}</td>
                    {{-- <td>{{$users->role_title}}</td> --}}
                    <td>{{$users->email}}</td>
                    <td>{{$users->phone}}</td>
                    <td>{{$users->country}}</td>
                    <td><img src="{{asset('storage/app/public/images/'.$users->logo)}}" style="height: 50px;" alt="User Image"></td>
                    <td>{{$users->total_point_available}}</td>
                    <td>{{$users->total_cash_available}}</td>
                    <td>
                      @if ($users->status==1)
                      <a onclick="return confirm('Are you sure deactivate user : {{$users->name}}?')" href="{{route('userStatus',[encrypt($users->id)])}}"><input type="button" class="btn btn-success" value="Activated"></a>
                      @else
                      <a onclick="return confirm('Are you sure activate user : {{$users->name}}?')"  href="{{route('userStatus',[encrypt($users->id)])}}"><input type="button" class="btn btn-warning" value="Inactive"></a>
                      @endif  
                     </td>
                    <td>
                      <a href="{{route('edituser',[encrypt($users->id)])}}"><button type="button" class="btn btn-success" ><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('Are you sure remove user : {{$users->name}}?')" href="{{route('removeUser',[encrypt($users->id)])}}"><button type="button" class="btn btn-danger" ><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a> 

                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                
                </table>
              </div>
              <!-- /.card-body -->
              <div class="row">
                  <div class="col-md-10"></div>
                <div class="col-md-2">
                    <p class="text-sm text-gray-700 leading-5">
                    	{!! __('Showing') !!}
                    	<span class="font-medium">{{ $user->firstItem() }}</span>
                    	{!! __('to') !!}
                    	<span class="font-medium">{{ $user->lastItem() }}</span>
                    	{!! __('of') !!}
                    	<span class="font-medium">{{ $user->total() }}</span>
                    	{!! __('results') !!}
                    </p>
                    @if ($user->hasPages())
                        <ul class="pagination pagination">
                            {{-- Previous Page Link --}}
                            @if ($user->onFirstPage())
                                <li class="disabled page-item"><a href="{{$user->currentPage()}}" class="page-link"><span>«</span></a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $user->previousPageUrl() }}" rel="prev">«</a></li>
                            @endif
                    
                            @if($user->currentPage() > 3)
                                <li class="page-item"><a class="page-link" href="{{ $user->url(1) }}">1</a></li>
                            @endif
                            @if($user->currentPage() > 4)
                                <li class="page-item"><span>...</span></li>
                            @endif
                            @foreach(range(1, $user->lastPage()) as $i)
                                @if($i >= $user->currentPage() - 2 && $i <= $user->currentPage() + 2)
                                    @if ($i == $user->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $user->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                            @if($user->currentPage() < $user->lastPage() - 3)
                                <li class="page-item"><span class="page-link">...</span></li>
                            @endif
                            @if($user->currentPage() < $user->lastPage() - 2)
                                <li class="page-item"><a class="page-link" href="{{ $user->url($user->lastPage()) }}">{{ $user->lastPage() }}</a></li>
                            @endif
                    
                            {{-- Next Page Link --}}
                            @if ($user->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $user->nextPageUrl() }}" rel="next">»</a></li>
                            @else
                                <li class="page-item disabled"><a href="{{$user->lastPage()}}" class="page-link"><span>»</span></a></li>
                            @endif
                        </ul>
                    @endif      
                </div>
              </div>
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
