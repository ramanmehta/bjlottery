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
              <h1>New Lucky Draw</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Lucky Draw Games</li>
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
                    <h3 class="card-title">Create New Game</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('user.LuckyDraw')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_title">Game Title</label>
                          <input type="text" class="form-control" id="game_title" placeholder="Enter game title" name="game_title" required>
                        </div>
                        
                      </div>
                      {{-- text editor --}}
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_description">Game Description</label>
                        
                          
                          <textarea id="game_description" name="game_description">
                            
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
                                <input type="text" class="form-control float-right" id="reservationtime" name="daterange">
                              </div>
                              
                            </div>

                        <div class="form-group col-md-6">
                          <label for="winning_prize_amount">Winning Prize Amount </label>
                          <input type="number" class="form-control" id="winning_prize_amount" placeholder="Enter winning prize amount" name="winning_prize_amount" required>
                        </div>
                      </div>

                      <div class="form-row">
                        
                        <div class="form-group col-md-6">
                          <label for="minimum_prize_amount">Minimum Prize Amount</label>
                          <input type="number" class="form-control" id="minimum_prize_amount" placeholder="Enter maximum point" name="minimum_prize_amount" required>
                        </div>

                        <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                              
                              <option disabled>Select Status</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
                        </div>
                      </div>


                      
      

                      <div class="form-row">
             
                        <div class="form-group col-md-6">
                          <label for="points_per_ticket">Points Per Ticket</label>
                          <input type="number" class="form-control" id="points_per_ticket" placeholder="Enter points for one ticket" name="points_per_ticket" required>
                        </div>

                        
       
                      </div>
                      

                      <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="winning_prize_amount">Game Image</label>
                        <input type="file" class="form-control" name="game_image" id="game_image">
                      </div>
                    </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <div class="col-4">
                        <input type="submit" class="btn btn-primary btn-block" value="Save">
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