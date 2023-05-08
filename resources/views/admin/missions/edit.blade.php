{{-- @php
dd($mission);
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
              <h1>Update Mission</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Update Mission</li>
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
                    <h3 class="card-title">Edit Mission</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('update.Mission',[encrypt($mission->id) ])}}" method="post" enctype="multipart/form-data">              
                    @csrf
                    
                    <div class="card-body">
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="mission_title">Mission Title</label>
                          <input type="text" class="form-control" id="mission_title" placeholder="Enter mission title" name="mission_title" value="{{$mission->mission_title}}" required disabled>
                        </div>
                        
                      </div>
                      {{-- text editor --}}
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="game_description">Mission Description</label>
                        
                          
                          <textarea id="game_description" name="mission_description">
                            {{$mission->mission_description}}
                          </textarea>
                        
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="mission_proof_type">Mission Proof Type</label>
                            <input type="text" class="form-control" name="mission_proof_type" id="mission_proof_type" value="{{$mission->mission_proof_type}}">
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="number_of_share">Number of Share Required</label>
                          <input type="number" class="form-control" id="number_of_share" placeholder="Enter number of referal required" name="number_of_share" value="{{$mission->number_of_share}}" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="banner_image">Banner Image</label>
                          <input type="file" class="form-control" id="banner_image" name="banner_image" value=""/>
                          <br>
                          <img src="{{asset('storage/app/public/images/'.$mission->banner_image)}}" style="height: 50px;" alt="User Image">
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group">
                            <label for="per_share_point">Per Share Point </label>
                            <input type="number" class="form-control" id="per_share_point" placeholder="Enter referal point" name="per_share_point" value="{{$mission->per_share_point}}" required>

                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          
                        </div>
                        
                        {{-- <div class="form-group col-md-6">
                          <label for="referal_code">Referal Code</label>
                          <input type="text" class="form-control" id="referal_code" placeholder="Enter referal code" name="referal_code" value="{{$mission->referal_code}}" required>
                        </div> --}}


                        <div class="form-group col-md-6" style="display:none;">

                          <label>Date and time range:</label>
  
                          <div class="input-group" style="display:none;">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservationtime" name="daterange" value="2023/05/08 20:20:42 - 2023/05/08 23:59:59">
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