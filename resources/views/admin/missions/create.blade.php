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
              <h1>New Mission</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Missions</li>
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
                    <h3 class="card-title">Create New Mission</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start-->
                  <form action="{{route('user.Mission')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="mission_title">Mission Title</label>
                          <input type="text" class="form-control" id="mission_title" placeholder="Enter mission title" name="mission_title" required>
                        </div>
                        
                      </div>
                      {{-- text editor --}}
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_description">Mission Description</label>
                        
                          
                          <textarea id="game_description" name="mission_description">
                            
                          </textarea>
                        
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="mission_proof_type">Mission Proof Type</label>
                          <input type="text" class="form-control" name="mission_proof_type" id="mission_proof_type">
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="number_of_share">Number of Share Required</label>
                          <input type="number" class="form-control" id="number_of_share" placeholder="Enter number of referal required" name="number_of_share" required>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="per_share_point">Per Share Point </label>
                          <input type="number" class="form-control" id="per_share_point" placeholder="Enter referal point" name="per_share_point" required>
                        </div>
                        
                        <!--<div class="form-group col-md-6">-->
                        <!--  <label for="referal_code">Referal Code</label>-->
                        <!--  <input type="text" class="form-control" id="referal_code" placeholder="Enter referal code" name="referal_code" required>-->
                        <!--</div>-->
                        <div class="form-group col-md-6">

                          <label>Date and time range:</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservationtime" name="daterange">
                          </div>
                          
                        </div>
                      </div>
                      
                      {{-- date input --}}

                      <div class="form-row">
                        
                        {{-- <div class="form-group col-md-6">
                          <label for="mission_start_date">Mission Start Date</label>
                          <input type="datetime-local" class="form-control" name="mission_start_date" id="mission_start_date"> --}}
                          {{-- <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" id="start_date_time" data-target="#reservationdate"/>
                          
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div> --}}
                        {{-- </div> --}}
                        
                        {{-- <div class="form-group col-md-6">
                          <label for="mission_end_date">Mission End Date</label>
                          <input type="datetime-local" class="form-control" name="mission_end_date" id="mission_end_date">
                          
                        </div> --}}
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

                      {{-- end date input --}}
                      
                      {{-- <div class="form-row"> --}}

                        {{-- <div class="form-group col-md-6">
                          <label for="game_point">Game Points</label>
                          <input type="number" class="form-control" id="game_point" placeholder="Enter maximum point" name="game_point" required>
                        </div> --}}
                        {{-- <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>
                              
                              <option disabled>Select Status</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
                        </div> --}}
                      {{-- </div> --}}

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
              // format: 'MM/DD/YYYY H:mm:ss'
              format: 'YYYY/MM/DD H:mm:ss'
            }
          });
               
    </script>
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection