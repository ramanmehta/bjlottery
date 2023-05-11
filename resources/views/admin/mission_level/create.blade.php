@extends('admin.layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>New Mission Level</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                <li class="breadcrumb-item active">Mission Level</li>
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
                    <h3 class="card-title">Create New Mission Level</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start-->
                  <form action="{{route('createlevels.store')}}" method="post" enctype="multipart/form-data">
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
                              <option value="<?php echo $key; ?>"><?php echo $missiondata; ?></option>
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
                          <input type="text" class="form-control" id="level_title" placeholder="Enter mission title" name="level_title" required>
                        </div>                        
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="level_description">Mission Level Description</label>       
                          <textarea id="level_description" name="level_description"></textarea>
                        </div>
                      </div>

                      <div class="form-row">                        
                        <div class="form-group col-md-6">
                          <label for="max_referals">Number of Share Required</label>
                          <input type="number" class="form-control" id="max_referals" placeholder="Enter number of referal required" name="max_referals" required>
                        </div>
                      </div>
                      <div class="form-row">                        
                        <div class="form-group col-md-6">
                          <label for="level_order">Order Level</label>
                          <input type="number" class="form-control" id="level_order" placeholder="Enter number of referal required" name="level_order" required>
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
                    
                    <!-- <div class="card-footer">
                      <div class="col-md-2">
                        <input type="submit" class="btn btn-primary btn-block" value="Save">
                        
                      </div>
                      <div class="col-md-2"><a href="{{route('mission')}}"><button type="button" class="ry btn-block"> Back </button></a></div>
                    </div> -->
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
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection