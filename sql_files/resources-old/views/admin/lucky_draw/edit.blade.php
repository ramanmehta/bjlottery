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
                          <input type="text" class="form-control" id="game_title" placeholder="Enter game title" name="game_title" value="{{$luckyDraw->game_title}}" required>
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

                          <label>Date and time range:</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservationtime" name="daterange" value="{{$dateRange}}">
                          </div>
                          
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label for="winning_prize_amount">Game Image</label>
                            <input type="file" class="form-control" name="game_image" id="game_image">
                        </div> --}}
                        
                        <div class="form-group col-md-6">
                          <label for="winning_prize_amount">Winning Prize Amount </label>
                          <input type="number" class="form-control" id="winning_prize_amount" placeholder="Enter game title" name="winning_prize_amount" value="{{$luckyDraw->winning_prize_amount}}" min="0" required>
                        </div>
                      </div>

                      <div class="form-row">                        

                        <div class="form-group col-md-6">
                          <label for="minimum_prize_amount">Minimum Prize Amount</label>
                          <input type="number" class="form-control" id="minimum_prize_amount" placeholder="Enter maximum point" name="minimum_prize_amount" value="{{$luckyDraw->minimum_prize_amount}}" min="0" required>
                        </div>

                        <div class="form-group col-md-6">
                          <label for="points_per_ticket">Points Per Ticket</label>
                          <input type="number" class="form-control" id="points_per_ticket" placeholder="Enter points for one ticket" name="points_per_ticket"  value="{{$luckyDraw->points_per_ticket}}" min="0" required>
                        </div>

                        {{-- <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                              <option disabled>Select Status</option>
                              <option value="1" {{$luckyDraw->status == 1 ? "selected" : ""}}>Active</option>
                              <option value="0" {{$luckyDraw->status == 0 ? "selected" : ""}}>Inactive</option>
                            </select>
                          </div>
                        </div> --}}
                      </div>
                      
                      {{-- date input --}}

                      {{-- <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="start_date_time">Start Game Date</label>
                          
                          <input type="datetime-local" class="form-control" name="start_date_time" id="start_date_time" value="{{$luckyDraw->start_date_time}}">
                          
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="end_date_time">End Game Date</label>
                          <input type="datetime-local" class="form-control" name="end_date_time" id="end_date_time" value="{{$luckyDraw->end_date_time}}">
                          
                        </div>
                      </div> --}}

                      {{-- end date input --}}
                      
                      <div class="form-row">

                        

                        

                      </div>

                      <div class="row">
                        <div class="form-group col-md-6">
                          <label for="winning_prize_amount">Game Image</label>
                          <input type="file" class="form-control" name="game_image" id="game_image">
                        </div>
                      </div>
                      @if($luckyDraw->game_image != "")
			
			                  <div class="form-group col-md-12">
                          
                          <img src="{{asset('storage/app/public/images'.$luckyDraw->game_image)}}" style="height: 50px;">
                          {{-- <img src="{{$this->fileurl.'/luckydraw/'.$luckyDraw->game_image}}" style="height: 50px;"> --}}
                        </div>
			
			                  @endif

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
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

        <!-- date-range-picker -->
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script>
          

        var today = new Date(); 
    
    
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            minDate:today,
            // timePickerIncrement: 30,
            locale: {
              // format: 'MM/DD/YYYY hh:mm:ss'
              format: 'YYYY-MM-DD H:mm:ss'
            }
          });
               
    </script>
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection