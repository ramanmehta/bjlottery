@extends('admin.layouts.app')

@section('content')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reward Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Reward Type</li>
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
                <h3 class="card-title">All Rewards</h3>
                <a href="{{route('createRewardType')}}"><button type="button" class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i>Add Reward Type</button></a>
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
              <div class="row mb-2">
                <div class="col-sm-6">
                  {{-- <h1>Users</h1> --}}
                </div>
                <div class="col-sm-6">
                  <form action="" method="get">
                  <div class="input-group mb-3 ">
                    
                    <input type="search" class="form-control" placeholder="Search here" aria-label="search user" aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}" id="search">
                    <input class="btn btn-outline-secondary" type="submit" value="Search">
                    
                  </div>
                </form>
                </div>
              </div>
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <!--<th>Id</th>-->
                    <th>Reward Title</th>
                    <th>Reward Type</th>
                    <th>Reward Description</th>
                    <th>Reward Point</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($rewardType as $rewardTypes)
                  <tr>
                    <!--<td>{{$rewardTypes->id}}</td>-->
                    <td>{{$rewardTypes->reward_title}}</td>
                    <td>{{$rewardTypes->reward_type}}</td>
                    <td>{{$rewardTypes->reward_description}}</td>
                    <td>{{$rewardTypes->reward_points}}</td>
                    <td>
                      @if ($rewardTypes->status==1)
                      <a onclick="return confirm('Are you sure deactivate Reward : {{$rewardTypes->reward_title}}?')" href="{{route('rewardStatus',[encrypt($rewardTypes->id)])}}"><input type="button" class="btn btn-success btn-sm" value="Active"></a>
                      @else
                      <a onclick="return confirm('Are you sure activate Reward : {{$rewardTypes->reward_title}}?')" href="{{route('rewardStatus',[encrypt($rewardTypes->id)])}}"><input type="button" class="btn btn-warning btn-sm" value="Inactive"></a>
                      @endif  
                     </td>
                    <td>
                      <a href="{{route('editRewardType',[encrypt($rewardTypes->id)])}}"><button type="button" class="btn btn-success btn-sm" ><i class='fas fa-edit'></i>&nbsp;Edit</button></a> </a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('Are you sure remove reward :  {{$rewardTypes->reward_type}} ?')" href="{{route('removeRewardType',[encrypt($rewardTypes->id)])}}"><button type="button" class="btn btn-danger btn-sm" ><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a> 

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
                      <span class="font-medium">{{ $rewardType->firstItem() }}</span>
                      {!! __('to') !!}
                      <span class="font-medium">{{ $rewardType->lastItem() }}</span>
                      {!! __('of') !!}
                      <span class="font-medium">{{ $rewardType->total() }}</span>
                      {!! __('results') !!}
                    </p>
                    @if ($rewardType->hasPages())
                        <ul class="pagination pagination">
                            {{-- Previous Page Link --}}
                            @if ($rewardType->onFirstPage())
                                <li class="disabled page-item"><a href="{{$rewardType->currentPage()}}" class="page-link"><span>«</span></a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $rewardType->previousPageUrl() }}" rel="prev">«</a></li>
                            @endif
                    
                            @if($rewardType->currentPage() > 3)
                                <li class="page-item"><a class="page-link" href="{{ $rewardType->url(1) }}">1</a></li>
                            @endif
                            @if($rewardType->currentPage() > 4)
                                <li class="page-item"><span>...</span></li>
                            @endif
                            @foreach(range(1, $rewardType->lastPage()) as $i)
                                @if($i >= $rewardType->currentPage() - 2 && $i <= $rewardType->currentPage() + 2)
                                    @if ($i == $rewardType->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $rewardType->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                            @if($rewardType->currentPage() < $rewardType->lastPage() - 3)
                                <li class="page-item"><span class="page-link">...</span></li>
                            @endif
                            @if($rewardType->currentPage() < $rewardType->lastPage() - 2)
                                <li class="page-item"><a class="page-link" href="{{ $rewardType->url($rewardType->lastPage()) }}">{{ $rewardType->lastPage() }}</a></li>
                            @endif
                    
                            {{-- Next Page Link --}}
                            @if ($rewardType->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $rewardType->nextPageUrl() }}" rel="next">»</a></li>
                            @else
                                <li class="page-item disabled"><a href="{{$rewardType->lastPage()}}" class="page-link"><span>»</span></a></li>
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
    
@endsection
