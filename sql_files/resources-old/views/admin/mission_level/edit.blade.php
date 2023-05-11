@extends('admin.layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Update Mission Level</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Update Mission Level</li>
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
                  <button type="button" class="btn btn-danger toastsDefaultDanger">
                    {{ $error }}
                  </button>
                  @endforeach
                </ul>
           
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Edit Mission Level</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form action="{{route('editMissionLevel.id',[encrypt($mission_level->id) ])}}" method="post" enctype="multipart/form-data">
                    @csrf                    
                    <div class="card-body">
                      <div class="form-group col-md-6">
                        <div class="form-group">
                          <label>Select Mission</label>
                          <select class="form-control" name="mission_id" required>                              
                            <option disabled>Select Status</option>
                            <?php if(count($mission) > 0 ){
                              foreach($mission as $key=>$missiondata){
                            ?>  
                              <option value="<?php echo $key; ?>" <?php if($key == $mission_level->mission_id){ echo "selected='selected'"; } ?>><?php echo $missiondata; ?></option>
                            <?php 
                              }
                            } 
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="level_title">Mission Level Title</label>
                          <input type="text" class="form-control" id="level_title" placeholder="Enter mission title" name="level_title" value="{{$mission_level->level_title}}" required>
                          <input type="hidden" id="id" name="id" value="{{$mission_level->id}}">
                        </div>                        
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="level_description">Mission Level Description</label>       
                          <textarea id="level_description" name="level_description">{{$mission_level->level_description}}</textarea>
                        </div>
                      </div>

                      <div class="form-row">                        
                        <div class="form-group col-md-6">
                          <label for="max_referals">Number of Share Required</label>
                          <input type="number" class="form-control" id="max_referals" placeholder="Enter number of referal required" name="max_referals" value="{{$mission_level->max_referals}}" required>
                        </div>
                      </div>
                      <div class="form-row">                        
                        <div class="form-group col-md-6">
                          <label for="level_order">Order Level</label>
                          <input type="number" class="form-control" id="level_order" placeholder="Enter number of referal required" name="level_order" value="{{$mission_level->level_order}}" required>
                        </div>
                      </div>

                      <div class="form-row">                        
                       
                        <!-- <div class="form-group col-md-6">
                          <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" required>                              
                              <option disabled>Select Status</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
                        </div> -->
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="container">
                      <div class="row">
                        <div class="col-md-6"><input type="submit" class="btn btn-primary btn-block" value="Save"></div>
                        <div class="col-md-6"><a href="{{route('mission')}}"><button type="button" class="btn btn-primary btn-block"> Cancel </button></a></div>
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