@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Missions List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Missions List</li>
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
              <h3 class="card-title">Missions</h3>
              <a href="{{route('createMission')}}"><button type="button" class="btn btn-primary float-right"><i
                    class='fas fa-plus-circle'></i> Add New Mission</button></a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
              <br>
              <div class="row mb-2">
                <div class="col-sm-6">
                  {{-- <h1>Users</h1> --}}
                </div>
                <div class="col-sm-6">

                  <form action="" method="get">
                    <div class="input-group mb-3 ">

                      <input type="search" class="form-control" placeholder="Search here" aria-label="search mission"
                        aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}"
                        id="search">
                      &nbsp;
                      &nbsp;
                      <input class="btn btn-outline-secondary" type="submit" value="Search">
                    </div>
                  </form>
                </div>
              </div>

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
              <table id="example2" class="table table-bordered table-hover text-center">
                <thead>
                  <tr>
                    <th>Banner Image</th>
                    <th>Mission Title</th>
                    <th>Mission Description</th>
                    <th>Mission Type</th>
                    <th>Enter Earn Affliated Points</th>
                    <th>Prize Name</th>
                    <th>Prize Image</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mission as $missions)
                  <tr>
                    <td><img src="{{$missions->banner_image}}" style="height: 50px;" alt="User Image"></td>
                    <td>{{$missions->mission_title}}</td>
                    <td>{!!$missions->mission_description!!}</td>
                    <td>{{$missions->mission_type}}</td>
                    <td>{{$missions->enter_earn_affliated_points}}</td>
                    @if ($missions->prize_name == null)
                    <td>---</td>
                    @else
                    <td>{{$missions->prize_name}}</td>
                    @endif
                    @if ($missions->prize_image == null)
                    <td>---</td>
                    @else
                    <td><img src="{{$missions->prize_image}}" style="height: 50px;" alt="User Image"></td>
                    @endif
                    <td>
                      @if ($missions->status==1)
                      <a onclick="return confirm('Are you sure deactivate Mission : {{$missions->mission_title}}?')"
                        href="{{route('missionStatus',[encrypt($missions->id)])}}"><input type="button"
                          class="btn btn-success btn-sm" value="Active"></a>
                      @else
                      <a onclick="return confirm('Are you sure activate Mission : {{$missions->mission_title}}?')"
                        href="{{route('missionStatus',[encrypt($missions->id)])}}"><input type="button"
                          class="btn btn-warning btn-sm" value="Inactive"></a>
                      @endif
                    </td>
                    <td>
                      <a class="btn btn-info btn-sm" href="{{ route('mission-submissions.index',$missions->id) }}"><i class="fa fa-eye"></i> View Submissions</a>
                    </td>
                    <td>
                      <a href="{{route('editMission',[encrypt($missions->id)])}}"><button type="button"
                          class="btn btn-success btn-sm"><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('if you delete mission then associated submissions will delete , change the status of mission instead of deleting mission')"
                        href="{{route('removeMission',[encrypt($missions->id)])}}"><button type="button"
                          class="btn btn-danger btn-sm"><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a>
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
                  <span class="font-medium">{{ $mission->firstItem() }}</span>
                  {!! __('to') !!}
                  <span class="font-medium">{{ $mission->lastItem() }}</span>
                  {!! __('of') !!}
                  <span class="font-medium">{{ $mission->total() }}</span>
                  {!! __('results') !!}
                </p>

                @if ($mission->hasPages())
                <ul class="pagination pagination">
                  {{-- Previous Page Link --}}
                  @if ($mission->onFirstPage())
                  <li class="disabled page-item"><a href="{{$mission->currentPage()}}"
                      class="page-link"><span>«</span></a></li>
                  @else
                  <li class="page-item"><a class="page-link" href="{{ $mission->previousPageUrl() }}" rel="prev">«</a>
                  </li>
                  @endif

                  @if($mission->currentPage() > 3)
                  <li class="page-item"><a class="page-link" href="{{ $mission->url(1) }}">1</a></li>
                  @endif
                  @if($mission->currentPage() > 4)
                  <li class="page-item"><span>...</span></li>
                  @endif
                  @foreach(range(1, $mission->lastPage()) as $i)
                  @if($i >= $mission->currentPage() - 2 && $i <= $mission->currentPage() + 2)
                    @if ($i == $mission->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $mission->url($i) }}">{{ $i }}</a></li>
                    @endif
                    @endif
                    @endforeach
                    @if($mission->currentPage() < $mission->lastPage() - 3)
                      <li class="page-item"><span class="page-link">...</span></li>
                      @endif
                      @if($mission->currentPage() < $mission->lastPage() - 2)
                        <li class="page-item"><a class="page-link" href="{{ $mission->url($mission->lastPage()) }}">{{
                            $mission->lastPage() }}</a></li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($mission->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $mission->nextPageUrl() }}" rel="next">»</a>
                        </li>
                        @else
                        <li class="page-item disabled"><a href="{{$mission->lastPage()}}"
                            class="page-link"><span>»</span></a></li>
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