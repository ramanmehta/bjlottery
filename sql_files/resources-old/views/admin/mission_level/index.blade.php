

@extends('admin.layouts.app')

@section('content')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Game Mission Levels</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Game Mission Levels</li>
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
                <h3 class="card-title">Levels</h3>
                <a href="{{route('mission')}}"><button type="button" class="btn btn-primary float-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back </button></a>
                &nbsp;&nbsp;&nbsp;&nbsp;
              </div>
              
              <div class="row mb-2 mt-4">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6 ">
                  <a href="{{route('createlevels')}}"><button type="button" class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i>Add New Level</button></a>
                  <br>
                  <form class="mt-4" action="" method="get">
                  <div class="input-group mb-3 ">
                    
                    <!-- <input type="search" class="form-control" placeholder="Search here" aria-label="search mission" aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}" id="search">
                    <input class="btn btn-outline-secondary" type="submit" value="Search"> -->
                    
                  </div>
                </form>
                
                </div>
              </div>
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
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Mission Title</th>
                    <th>Level Title</th>
                    <th>Level Description</th>
                    <th>Total Share required</th>
                    <th>Level Order</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <!-- <tr colspan="6">No record found.</tr> -->
                    <?php if($mission_levels->total() > 0) { ?>
                        @foreach ($mission_levels as $mission_level)
                          <tr>
                            <td>{{$mission_level->mission->mission_title}}</td>
                            <td>{{$mission_level->level_title}}</td>
                            <td>{{strip_tags($mission_level->level_description)}}</td>
                            <td>{{$mission_level->max_referals}}</td>
                            <td>{{$mission_level->level_order}}</td>                          
                            <td>
                              <a href="{{route('editMissionLevel',[encrypt($mission_level->id)])}}"><button type="button" class="btn btn-success" ><i c='fas fa-edit'></i>&nbsp;Edit</button></a>
                              &nbsp;&nbsp;
                              <a onclick="return confirm('Are you sure remove misssion: {{$mission_level->mission_title}}?')" href="{{route('removeLevelMission',[encrypt($mission_level->id),encrypt($mission_level->mission_id)])}}"><button type="button" class="btn btn-danger" ><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a>
                            </td>
                          </tr>
                        @endforeach
                    <?php }else{ ?>
                        <!-- <tr colspan="6">No record found.</tr>  -->
                    <?php } ?>
                  </tbody>                
                </table>
              </div>
              <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <p class="text-sm text-gray-700 leading-5">
                      {!! __('Showing') !!}
                      <span class="font-medium">{{ $mission_levels->firstItem() }}</span>
                      {!! __('to') !!}
                      <span class="font-medium">{{ $mission_levels->lastItem() }}</span>
                      {!! __('of') !!}
                      <span class="font-medium">{{ $mission_levels->total() }}</span>
                      {!! __('results') !!}
                    </p>
                    @if ($mission_levels->hasPages())
                        <ul class="pagination pagination">
                            {{-- Previous Page Link --}}
                            @if ($mission_levels->onFirstPage())
                                <li class="disabled page-item"><a href="{{$mission_levels->currentPage()}}" class="page-link"><span>«</span></a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $mission_levels->previousPageUrl() }}" rel="prev">«</a></li>
                            @endif
                    
                            @if($mission_levels->currentPage() > 3)
                                <li class="page-item"><a class="page-link" href="{{ $mission_levels->url(1) }}">1</a></li>
                            @endif
                            @if($mission_levels->currentPage() > 4)
                                <li class="page-item"><span>...</span></li>
                            @endif
                            @foreach(range(1, $mission_levels->lastPage()) as $i)
                                @if($i >= $mission_levels->currentPage() - 2 && $i <= $mission_levels->currentPage() + 2)
                                    @if ($i == $mission_levels->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $mission_levels->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                            @if($mission_levels->currentPage() < $mission_levels->lastPage() - 3)
                                <li class="page-item"><span class="page-link">...</span></li>
                            @endif
                            @if($mission_levels->currentPage() < $mission_levels->lastPage() - 2)
                                <li class="page-item"><a class="page-link" href="{{ $mission_levels->url($mission_levels->lastPage()) }}">{{ $mission_levels->lastPage() }}</a></li>
                            @endif
                    
                            {{-- Next Page Link --}}
                            @if ($mission_levels->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $mission_levels->nextPageUrl() }}" rel="next">»</a></li>
                            @else
                                <li class="page-item disabled"><a href="{{$mission_levels->lastPage()}}" class="page-link"><span>»</span></a></li>
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
