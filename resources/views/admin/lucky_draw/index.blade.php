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
            <h1>Lucky Draw Games</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
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
                <a href="/admin/createLuckyDraw"><button type="button" class="btn btn-primary float-right"><i class='fas fa-plus-circle'></i> Add Lucky Draw</button></a>
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
                    <th>Game Title</th>
                    <th>Dame Description</th>
                    <th>Game Image</th>
                    <th>Winning Prize Amount</th>
                    <th>Min Point</th>
                    <th>Max Point</th>
                    <th>Start Date Time </th>
                    <th>End Date Time</th>
                    <th>Game Point</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($luckyDraw as $luckyDraws)
                  <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{$luckyDraws->game_title}}</td>
                    <td>{{$luckyDraws->game_description}}</td>
                    <td>{{$luckyDraws->game_image}}</td>
                    <td>{{$luckyDraws->winning_prize_amount}}</td>
                    <td>{{$luckyDraws->min_point}}</td>
                    <td>{{$luckyDraws->max_point}}</td>
                    <td>{{$luckyDraws->start_date_time}}</td>
                    <td>{{$luckyDraws->end_date_time}}</td>
                    <td>{{$luckyDraws->game_point}}</td>
                    <td>
                      @if ($luckyDraws->status==1)
                      <input type="button" class="btn btn-success" value="Active">
                      @else
                      <input type="button" class="btn btn-warning" value="Inactive">
                      @endif  
                     </td>
                    <td>
                      <a href="/admin/editLuckyDraw/{{encrypt($luckyDraws->id)}}"><button type="button" class="btn btn-success" ><i class='fas fa-edit'></i>&nbsp;Edit</button></a>
                      &nbsp;&nbsp;
                      <a onclick="return confirm('Are you sure remove lucky draw : {{$luckyDraws->game_title}}?')" href="/admin/deleteLuckyDraw/{{encrypt($luckyDraws->id)}}"><button type="button" class="btn btn-danger" ><i class='fas fa-trash-alt'></i>&nbsp;Remove</button></a> 

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
