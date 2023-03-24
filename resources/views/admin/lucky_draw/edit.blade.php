{{-- @php
dd($luckyDraw);
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
              <h1>Update Lucky Draw</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Update Lucky Draw</li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
        <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">

                <ul>
                  @foreach ($errors->all() as $error)
                  <button type="button" class="btn btn-warning toastsDefaultWarning">
                    {{ $error }}
                  </button>
                  @endforeach
                </ul>
           
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Game</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('update.LuckyDraw',[encrypt($luckyDraw->id) ])}}" method="post" enctype="multipart/form-data">              
                    @csrf
                    
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_title">Game Title</label>
                          <input type="text" class="form-control" id="game_title" placeholder="Enter game title" name="game_title" value="{{$luckyDraw->game_title}}" required disabled>
                        </div>
                        
                      </div>
                      {{-- text editor --}}
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_description">Game Description</label>
                        
                          
                          <textarea id="game_description" name="game_description">
                            {{$luckyDraw->game_description}}
                          </textarea>
                        
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="winning_prize_amount">Game Image</label>
                            <input type="file" class="form-control" name="game_image" id="game_image">
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="winning_prize_amount">Winning Prize Amount </label>
                          <input type="number" class="form-control" id="winning_prize_amount" placeholder="Enter game title" name="winning_prize_amount" value="{{$luckyDraw->winning_prize_amount}}" required>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="min_point">Minimum Points</label>
                          <input type="number" class="form-control" id="min_point" placeholder="Enter minimum point" name="min_point" value="{{$luckyDraw->min_point}}" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="max_point">Maximum Points</label>
                          <input type="number" class="form-control" id="max_point" placeholder="Enter maximum point" name="max_point" value="{{$luckyDraw->max_point}}" required>
                        </div>
                      </div>
                      
                      {{-- date input --}}

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="start_date_time">Start Game Date</label>
                          
                          <input type="datetime-local" class="form-control" name="start_date_time" id="start_date_time" value="{{$luckyDraw->start_date_time}}">
                          
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="end_date_time">End Game Date</label>
                          <input type="datetime-local" class="form-control" name="end_date_time" id="end_date_time" value="{{$luckyDraw->end_date_time}}">
                          
                        </div>
                      </div>

                      {{-- end date input --}}
                      
                      <div class="form-row">

                        <div class="form-group col-md-6">
                          <label for="game_point">Game Points</label>
                          <input type="number" class="form-control" id="game_point" placeholder="Enter maximum point" name="game_point" value="{{$luckyDraw->game_point}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" value="{{$luckyDraw->status}}" required>
                              
                              <option disabled>Select Status</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
                        </div>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <div class="col-4">
                        <input type="submit" class="btn btn-primary btn-block" value="Update">
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.card-primary -->
            </div>
            <!--/.col-md-12 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection