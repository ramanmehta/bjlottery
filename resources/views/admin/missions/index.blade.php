
@extends('admin.layouts.app')

@section('content')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Game Missions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Game Missions</li>
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
<<<<<<< HEAD
                <a href="/admin/createMission"><button type="button" class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i>Add New Mission</button></a>
              </div>
              
              
=======
                <a href="{{route('createMission')}}"><button type="button" class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i>Add New Mission</button></a>
              </div>
              
              <div class="row mb-2">
                <div class="col-sm-6">
                  {{-- <h1>Users</h1> --}}
                </div>
                <div class="col-sm-6">
                  <form action="" method="get">
                  <div class="input-group mb-3 ">
                    
                    <input type="search" class="form-control" placeholder="Search here" aria-label="search mission" aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}" id="search">
                    <input class="btn btn-outline-secondary" type="submit" value="Search">
                    
                  </div>
                </form>
                </div>
              </div>
>>>>>>> 541b8c452e1b7d07206b3f089092f39fd0756b91
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
<<<<<<< HEAD
                    <th>Id</th>
                    <th>Mission Title</th>
                    <th>Mission Description</th>
                    <th>Mission Proof</th>
                    <th>Number Of Referals Required</th>
                    <th>Referal Unit Point</th>
                    <th>Referal Code</th>
                    <th>Mission Start Date</th>
                    <th>Mission End Date</th>
=======
                    <th>Mission Title</th>
                    <th>Mission Description</th>
                    <th>Mission Proof Type</th>
                    <!-- <th>Number of Share Required</th> -->
                    <th>Each Share Point</th>
                    <th>Levels</th>
>>>>>>> 541b8c452e1b7d07206b3f089092f39fd0756b91
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($mission as $missions)
                  <tr>
<<<<<<< HEAD
                    <td>{{ $loop->index }}</td>
                    <td>{{$missions->mission_title}}</td>
                    <td>{{$missions->mission_description}}</td>
                    <td>{{$missions->mission_proof_type}}</td>
                    <td>{{$missions->number_of_referals_required}}</td>
                    <td>{{$missions->referal_unit_point}}</td>
                    <td>{{$missions->referal_code}}</td>
                    <td>{{$missions->mission_start_date}}</td>
                    <td>{{$missions->mission_end_date}}</td>
                    <td>
                      @if ($missions->status==1)
                      <input type="button" class="btn btn-success" value="Active">
                      @else
                      <input type="button" class="btn btn-warning" value="Inactive">
                      @endif  
                     </td>
                    <td>
                      <a href="/admin/editMission/{{encrypt($missions->id)}}"><button type="button" class="btn btn-success" ><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('Are you sure remove misssion: {{$missions->mission_title}}?')" href="/admin/deleteMission/{{encrypt($missions->id)}}"><button type="button" class="btn btn-danger" ><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a> 

=======
                    <td>{{$missions->mission_title}}</td>
                    <td>{{$missions->mission_description}}</td>
                    <td>{{$missions->mission_proof_type}}</td>
                    <!-- <td>{{$missions->number_of_share}}</td> -->
                    <td>{{$missions->per_share_point}}</td>
                    <td><a href="{{route('levels',[encrypt($missions->id)])}}"><button type="button" class="btn btn-success">&nbsp;Levels</button></a></td>
                    <td>
                      @if ($missions->status==1)
                      <a onclick="return confirm('Are you sure deactivate Mission : {{$missions->mission_title}}?')" href="{{route('missionStatus',[encrypt($missions->id)])}}"><input type="button" class="btn btn-success" value="Active"></a>
                      @else
                      <a onclick="return confirm('Are you sure activate Mission : {{$missions->mission_title}}?')" href="{{route('missionStatus',[encrypt($missions->id)])}}"><input type="button" class="btn btn-warning" value="Inactive"></a>
                      @endif  
                     </td>
                    <td>
                      <a href="{{route('editMission',[encrypt($missions->id)])}}"><button type="button" class="btn btn-success" ><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('Are you sure remove misssion: {{$missions->mission_title}}?')" href="{{route('removeMission',[encrypt($missions->id)])}}"><button type="button" class="btn btn-danger" ><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a>
>>>>>>> 541b8c452e1b7d07206b3f089092f39fd0756b91
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                
                </table>
              </div>
<<<<<<< HEAD
=======
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
                                <li class="disabled page-item"><a href="{{$mission->currentPage()}}" class="page-link"><span>«</span></a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $mission->previousPageUrl() }}" rel="prev">«</a></li>
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
                                <li class="page-item"><a class="page-link" href="{{ $mission->url($mission->lastPage()) }}">{{ $mission->lastPage() }}</a></li>
                            @endif
                    
                            {{-- Next Page Link --}}
                            @if ($mission->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $mission->nextPageUrl() }}" rel="next">»</a></li>
                            @else
                                <li class="page-item disabled"><a href="{{$mission->lastPage()}}" class="page-link"><span>»</span></a></li>
                            @endif
                        </ul>
                    @endif      
                </div>
              </div>
>>>>>>> 541b8c452e1b7d07206b3f089092f39fd0756b91
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
