@extends('admin.layouts.app')

@section('content')
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lucky Draw Games</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Lucky Draw</li>
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
                <h3 class="card-title">Lucky Draw Games</h3>
                <a href="{{route('createLuckyDraw')}}"><button type="button" class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i> Add Lucky Draw</button></a>
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
                      
                      <input type="search" class="form-control" placeholder="Search here" aria-label="Search Lottery" aria-describedby="basic-addon2" name="search" value="{{ request()->get('search') }}" id="search">
                      <input class="btn btn-outline-secondary" type="submit" value="Search">
                      
                    </div>
                </form>
                </div>
              </div>
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    {{-- <th>Id</th> --}}
                    <th>Game Title</th>
                    <th>Game Description</th>
                    <th>Game Image</th>
                    <th>Winning Prize Amount</th>
                    <th>Minimum Prize Amount</th>
                    <th>Points For Unit Ticket</th>
                    <th>Start Date Time </th>
                    <th>End Date Time</th>  
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($luckyDraw as $luckyDraws)
                  <tr>
                    {{-- <td>{{$luckyDraws->id}}</td> --}}
                    <td>{{$luckyDraws->game_title}}</td>
                    <td>{{$luckyDraws->game_description}}</td>
                    <td><img src="{{asset('storage/app/public/images'.$luckyDraws->game_image)}}" style="height: 50px;" alt="User Image"></td>
                   
                    {{-- <td><img src="{{request()->getHttpHost()."/bjlottery".$luckyDraws->game_image}}" style="height: 50px;" alt="User Image"></td> --}}
                    <td>{{$luckyDraws->winning_prize_amount}}</td>
                    <td>{{$luckyDraws->minimum_prize_amount}}</td>
                    <td>{{$luckyDraws->points_per_ticket}}</td>
                    <td>{{$luckyDraws->start_date_time}}</td>
                    <td>{{$luckyDraws->end_date_time}}</td>
                    <td>
                      @if ($luckyDraws->status==1)
                      <a onclick="return confirm('Are you sure deactivate Lucky Draw : {{$luckyDraws->game_title}}?')" href="{{route('luckyDrawsStatus',[encrypt($luckyDraws->id)])}}"><input type="button" class="btn btn-success btn-xs" value="Active"></a>
                      @else
                      <a onclick="return confirm('Are you sure activate Lucky Draw : {{$luckyDraws->game_title}}?')" href="{{route('luckyDrawsStatus',[encrypt($luckyDraws->id)])}}"><input type="button" class="btn btn-warning btn-xs" value="Inactive"></a>
                      @endif  
                     </td>
                    <td>
                      <a href="{{route('editLuckyDraw',[encrypt($luckyDraws->id)])}}"><button type="button" class="btn btn-success btn-xs" ><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      <a onclick="return confirm('Are you sure remove lucky draw : {{$luckyDraws->game_title}}?')" href="{{route('removeLuckyDraw',[encrypt($luckyDraws->id)])}}" ><button type="button" class="btn btn-danger btn-xs"><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a> 
                      <a href="{{ route('add.price',[encrypt($luckyDraws->id)]) }}" ><button type="button" class="btn btn-info btn-xs"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        &nbsp;Add Price</button></a> 
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                
                </table>
              </div>
              <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <p class="text-sm text-gray-700 leading-5">
                      {!! __('Showing') !!}
                      <span class="font-medium">{{ $luckyDraw->firstItem() }}</span>
                      {!! __('to') !!}
                      <span class="font-medium">{{ $luckyDraw->lastItem() }}</span>
                      {!! __('of') !!}
                      <span class="font-medium">{{ $luckyDraw->total() }}</span>
                      {!! __('results') !!}
                    </p>
                    @if ($luckyDraw->hasPages())
                        <ul class="pagination pagination">
                            {{-- Previous Page Link --}}
                            @if ($luckyDraw->onFirstPage())
                                <li class="disabled page-item"><a href="{{$luckyDraw->currentPage()}}" class="page-link"><span>«</span></a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $luckyDraw->previousPageUrl() }}" rel="prev">«</a></li>
                            @endif
                    
                            @if($luckyDraw->currentPage() > 3)
                                <li class="page-item"><a class="page-link" href="{{ $luckyDraw->url(1) }}">1</a></li>
                            @endif
                            @if($luckyDraw->currentPage() > 4)
                                <li class="page-item"><span>...</span></li>
                            @endif
                            @foreach(range(1, $luckyDraw->lastPage()) as $i)
                                @if($i >= $luckyDraw->currentPage() - 2 && $i <= $luckyDraw->currentPage() + 2)
                                    @if ($i == $luckyDraw->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $luckyDraw->url($i) }}">{{ $i }}</a></li>
                                    @endif
                                @endif
                            @endforeach
                            @if($luckyDraw->currentPage() < $luckyDraw->lastPage() - 3)
                                <li class="page-item"><span class="page-link">...</span></li>
                            @endif
                            @if($luckyDraw->currentPage() < $luckyDraw->lastPage() - 2)
                                <li class="page-item"><a class="page-link" href="{{ $luckyDraw->url($luckyDraw->lastPage()) }}">{{ $luckyDraw->lastPage() }}</a></li>
                            @endif
                    
                            {{-- Next Page Link --}}
                            @if ($luckyDraw->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $luckyDraw->nextPageUrl() }}" rel="next">»</a></li>
                            @else
                                <li class="page-item disabled"><a href="{{$luckyDraw->lastPage()}}" class="page-link"><span>»</span></a></li>
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